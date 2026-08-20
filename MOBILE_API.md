# TraceSci Mobile API Reference

Everything the Flutter app needs. All new endpoints are **additive** — no existing
endpoint was changed, renamed or removed.

- **Base URL:** `https://<your-domain>/api`
- **Method:** every endpoint is `POST` (matches the existing API style)
- **Content type:** `application/json` or `multipart/form-data`

---

## 1. Authentication

Unchanged from the current app. Login returns an encrypted token; send it back on
every subsequent call.

### Login flow

| Step | Endpoint | Body | Returns |
|---|---|---|---|
| 1 | `POST /get-otp` | `country_code`, `phone` | `otp` (dev builds echo it back) |
| 2 | `POST /verify-otp` | `country_code`, `phone`, `otp` | `data.token`, `data.profile` |

Staff who log in with a password use `POST /password-login` (`username`, `password`)
and get the same `token`.

### New mobile auth (recommended)

Two separate paths, both ending in a 4 digit code. **Dev OTP is `1234`.**

**Consumer — phone only, signs up automatically**

```
POST /app/auth/consumer/request-otp   { phone_code: "91", phone: "9876543210" }
  -> data.is_new_user, data.dev_otp

POST /app/auth/consumer/verify        { phone_code, phone, otp }
  -> data.token, data.profile
```

If the number is unknown a `type = 0` consumer account is created on the spot.

**Official — email + password, then code**

```
POST /app/auth/official/request-otp   { email, password }
  -> data.name, data.role_label, data.dev_otp

POST /app/auth/official/verify        { email, otp }
  -> data.token, data.profile
```

Password is verified first; only then is a code issued. Consumer accounts are
rejected here and told to use the phone path.

The older `/get-otp`, `/verify-otp`, `/password-login` and `/without-auth`
routes are untouched and still work.

### Scan diagnosis, alerts and reporting with photos

```
POST /consumer/diagnose   { code }
  -> status: genuine | fake | not_activated | deactivated | blocked | expired | over_scanned
  -> title, message, is_problem, can_report, already_reported, product

POST /consumer/report     multipart
  fields: issue_type*, description*, code_data, product_id, batch, scan_id, location
  file:   photo   (png/jpg, max 8MB, stored under storage/app/public/reports)

POST /alerts              { page, limit, scope, status }
  scope: (omit) everything visible to me | mine | products
  -> alerts[], can_see_products, counts.mine, counts.products
```

**Who sees an alert.** Every alert is visible to the person who scanned it, and —
for brand, admin, authority and inspector accounts — to whoever owns the product.
So a manufacturer sees everything raised against their own products, and the
scanner always sees their own. `raised_by_me` marks which is which.

All timestamps are IST (`config/app.php` timezone is `Asia/Kolkata`).

### Sending the token

Any one of these works — pick whichever is cleanest in Dio:

```
// 1. form field  (what the current app does)
{ "token": "eyJpdiI6..." }

// 2. bearer header  (recommended for Flutter interceptors)
Authorization: Bearer eyJpdiI6...

// 3. custom header
X-Api-Token: eyJpdiI6...
```

### Response envelope

Every new endpoint answers in exactly this shape.

**Success — HTTP 200**
```json
{
  "success": true,
  "message": "Home loaded successfully",
  "data": { }
}
```

**Failure — HTTP 400 / 401 / 403 / 404 / 422**
```json
{
  "success": false,
  "message": "Session expired. Please login again.",
  "errors": { "token": ["Invalid or missing token"] }
}
```

**Paginated lists** add a top-level `meta`:
```json
{
  "success": true,
  "message": "...",
  "data": { "scans": [ ] },
  "meta": { "page": 1, "limit": 20, "total": 143, "last_page": 8, "has_more": true }
}
```

Send `page` and `limit` (max 100) on any list endpoint.

### Status codes

| Code | Meaning | App should |
|---|---|---|
| 200 | OK | render `data` |
| 400 | Bad request / validation | show `message` |
| 401 | Token invalid or expired | drop token, go to login |
| 403 | Wrong role, or account blocked | show `message`, go back |
| 404 | Not found | show empty state |
| 422 | Business rule blocked it | show `message` inline |

---

## 2. App shell — call this first

### `POST /app/bootstrap`

**The single most important endpoint.** Call it right after login and on every
cold start. It tells the app who the user is *and how to draw itself* — so no role
logic is hard-coded in Dart.

Returns:

| Field | Use |
|---|---|
| `profile` | name, phone, photo, company, supply chain node |
| `role` | `consumer` \| `supply_chain` \| `brand` \| `inspector` \| `authority` \| `admin` |
| `role_label` | display string for the header |
| `capabilities` | boolean feature map — show/hide whole sections |
| `tabs` | bottom nav items in order, each with `key`, `label`, `icon`, `endpoint` |
| `quick_actions` | home screen buttons, one flagged `primary` |
| `scanner` | tells the scan screen which mode to run and where to POST |
| `theme` | accent colour, greeting, display name |

Example `capabilities`:
```json
{
  "scan_product": true, "scan_supply_chain": false, "report_product": true,
  "rewards": true, "wallet": true, "cases": false, "brand_dashboard": false,
  "supply_chain_board": false, "alerts": false, "scan_history": true
}
```

### Other shell endpoints

| Endpoint | Body | Notes |
|---|---|---|
| `POST /app/me` | — | lightweight profile refresh |
| `POST /app/update-profile` | any of `name`, `first_name`, `last_name`, `email`, `dob`, `gender`, `address_one`, `address_two`, `zip`, `city_id` | all optional, only sent fields change |
| `POST /app/masters` | — | countries, supply chain status list, report issue types — cache on first launch |
| `POST /app/logout` | — | clears server-side OTP; app drops the token |
| `POST /app/delete-account` | — | consumer only, soft delete (Play Store requirement) |

---

## 3. Consumer

The end customer who scans a pack.

| Endpoint | Body | What it does |
|---|---|---|
| `POST /consumer/home` | — | **Whole home screen in one call**: 4 stat tiles, wallet balance per brand, last 5 scans, open report count, blog highlights |
| `POST /consumer/scans` | `page`, `limit`, `genuine` (0\|1), `search` | paginated scan history |
| `POST /consumer/scan/{scan_id}` | — | full detail: product, batch, expiry, genuine verdict, **and the supply chain journey that pack travelled** |
| `POST /consumer/report` | `issue_type`*, `description`*, `code_data`, `product_id`, `batch`, `image`, `location` | report a fake/damaged pack — only 2 required fields, everything else inferred from the code |
| `POST /consumer/reports` | `page`, `status` | reports this user filed + current status |
| `POST /consumer/notifications` | — | merged feed: reward credits + report status changes, newest first |

The existing scan endpoint is unchanged: `POST /p/{code}` with `token` and optional
`location`. Use it from the scanner, then `consumer/scan/{scan_id}` for the detail page.

**Minimal consumer journey: login → scan → result screen. Two taps.**

---

## 4. Rewards & wallet

Points are scoped per brand — points earned on Brand A cannot be spent on Brand B.

| Endpoint | Body | What it does |
|---|---|---|
| `POST /rewards/summary` | — | balance, lifetime earned/spent, cash redeemed, per-brand balances, pending orders, last 5 ledger rows |
| `POST /rewards/ledger` | `page`, `type` (credit\|debit), `brand` | wallet statement |
| `POST /rewards/catalog` | — | active schemes and their items; **every item carries `can_redeem` and `short_by`** so the app just greys out what's unaffordable |
| `POST /rewards/redeem-coupon` | `coupon_code`*, `scan_id` | scratch code under the label → points credited |
| `POST /rewards/redeem-cash` | `scheme_id`*, `points`*, `upi_id`*, `brand` | UPI payout via RazorpayX |
| `POST /rewards/order` | `scheme_id`*, `points`*, `name`*, `address`*, `city`*, `state`*, `pin_code`*, `brand` | redeem points for a physical reward |
| `POST /rewards/orders` | `page`, `status` | order history with a delivery `timeline` array |

---

## 5. Supply chain

For distributor / transporter / retail staff (`users.type = 5`).

### Custody model

Look at the most recent action on an aggregation code:

| Last action | Meaning for this user | Next allowed action |
|---|---|---|
| `checkin` by me | stock is **with me** | `checkout` |
| `checkout` for me | stock is **in transit to me** | `checkin` |
| `checkout` by me | I **dispatched** it, awaiting the other side | none |

### Endpoints

| Endpoint | Body | What it does |
|---|---|---|
| `POST /supply-chain/dashboard` | — | 4 stat tiles (in custody / awaiting check-in / dispatched / scans today), open alert count, recent activity |
| `POST /supply-chain/consignments` | `status` (`in_custody`\|`incoming`\|`dispatched`\|`all`), `search`, `page` | custody list; each card carries `custody`, `counterparty` and `eligible_for` |
| `POST /supply-chain/consignment/{unique_id}` | — | what's inside (products grouped with quantity), custody state, next allowed action, full timeline |
| `POST /supply-chain/timeline/{unique_id}` | — | movement trail only — for the track screen |
| `POST /supply-chain/counterparties` | — | who this user can hand stock to (downstream nodes + own parent for returns) |
| `POST /supply-chain/statuses` | — | condition codes: Received, Shipped, Received as damaged, Return, Recall, Dispose, Other |
| `POST /supply-chain/alerts` | `page` | wrong-location scans and other exceptions |
| `POST /supply-chain/my-activity` | `page` | everything this user scanned or actioned |

### Existing scan + action endpoints (unchanged, still the core)

```
POST /supply-chain/scan     { token, code, location }
  -> action.eligible_for : "checkin" | "checkout" | ""
     action.scan_id      : pass this to the action call
     action.users        : dropdown for checkout
     action.status       : condition codes
     products            : what's inside
     history             : movement trail

POST /supply-chain/action   { token, scan_id, action, user, comment, status }
```

Every action is hash-chained (`current_hash`, `parent_hash`, `block_hash`) — the
timeline entries expose a `verified` flag off that.

**Minimal supply chain journey: scan → server says checkin or checkout → one tap confirm.**

---

## 6. Inspector / Authority

Field investigation. A *case* is a row in `alerts` — either a system alert
(`type 0`, e.g. a fake code was scanned) or a consumer report (`type 1`).

| Endpoint | Body | What it does |
|---|---|---|
| `POST /inspector/dashboard` | — | open / closed / today / suspicious counts + 8 recent cases |
| `POST /inspector/cases` | `status` (0\|1), `type` (0\|1), `search`, `page` | case list |
| `POST /inspector/case/{id}` | — | full detail: product, code status, batch, reporter, manufacturer contact, journey, and an `actions` block saying what's allowed |
| `POST /inspector/case/{id}/update` | `status`* (0\|1), `comments`* | close or update a case |
| `POST /inspector/seize` | `type`* (0 = single code, 1 = whole batch), `code`* | deactivate counterfeit stock in the field |
| `POST /inspector/map` | `status` | case coordinates for the map screen |

Case visibility follows the existing web rules: admins see cases assigned to them,
brand users see cases assigned to their company, inspectors see the full queue.

---

## 7. Brand / Vendor dashboard

Read-mostly. Creating products, generating codes and ordering labels stay on the
web back office — this is the "how is my brand doing right now" view.

| Endpoint | Body | What it does |
|---|---|---|
| `POST /brand/dashboard` | — | products / codes / scans / alerts tiles, this-month numbers, label credits, 7-day scan sparkline, top 5 products, recent alerts, network size |
| `POST /brand/products` | `search`, `status`, `page` | product list with code and batch counts |
| `POST /brand/product/{id}` | — | detail + all batches + performance (codes, scans, open alerts) |
| `POST /brand/scans` | `product_id`, `genuine`, `page` | live consumer scan feed |
| `POST /brand/alerts` | `status`, `type`, `page` | alerts and reports against this brand |
| `POST /brand/network` | — | the supply chain tree, with each node's parent |
| `POST /brand/scan-map` | — | up to 500 scan coordinates for the heat map |

All brand data is scoped to the tenant (`parent_id ?? id`), so staff accounts
automatically see their company's data and nothing else.

---

## 8. Role → screen matrix

What each role sees, driven entirely by `bootstrap`:

| Screen | Consumer | Supply chain | Inspector | Brand |
|---|:--:|:--:|:--:|:--:|
| Scan product | ✅ | — | ✅ | ✅ |
| Scan consignment | — | ✅ | — | — |
| Rewards / wallet | ✅ | — | — | — |
| Report a fake | ✅ | — | ✅ | — |
| Custody & shipments | — | ✅ | — | ✅ |
| Cases | — | — | ✅ | ✅ |
| Brand KPIs | — | — | — | ✅ |
| Alerts | — | ✅ | ✅ | ✅ |

---

## 9. Flutter notes

- **One interceptor**, one envelope. Parse `success` / `message` / `data` once and
  every screen gets the same model.
- **401 → logout.** The only token error the app has to handle.
- **Drive the UI from `bootstrap`.** Tabs, quick actions and feature flags all come
  from the server, so adding a role later needs no app release.
- **Cache `/app/masters`** on first launch; it rarely changes.
- **Every list endpoint** takes `page` + `limit` and returns `meta.has_more` — wire
  that straight into an infinite scroll controller.
- **Dates come pre-formatted** (`scanned_at`) alongside a relative label
  (`scanned_ago`), so no date parsing is needed for display.
- **Images are absolute URLs** already, or `""` when missing.

---

## 10. Files added

```
app/Http/Controllers/Api/ApiController.php              base: token, envelope, roles, pagination
app/Http/Controllers/Api/Mobile/SessionController.php   bootstrap, profile, masters
app/Http/Controllers/Api/Mobile/ConsumerController.php  home, scans, reports, notifications
app/Http/Controllers/Api/Mobile/RewardController.php    wallet, catalog, redemption, orders
app/Http/Controllers/Api/Mobile/SupplyChainController.php  custody, consignments, timeline
app/Http/Controllers/Api/Mobile/InspectorController.php    cases, seize, map
app/Http/Controllers/Api/Mobile/BrandController.php        KPIs, products, scans, network
routes/api.php                                          new groups appended
```
