# TraceSci — Dashboard Data Setup Guide

The order below is not a suggestion. Each step depends on the one above it, and
a few steps will hard-fail the mobile API if skipped.

---

## 1. The dependency tree

```
Admin (type 1)
 └── Vendor / Manufacturer (type 2)          ← the "brand"
      ├── Credits                             ← required to generate QR codes
      ├── Product Template                    ← REQUIRED FIRST (see trap #1)
      ├── Product
      │    └── Batch                          ← mfg date / expiry
      │         └── QR Codes                  ← the sticker on the pack
      │              └── Aggregation
      │                   Primary   (box)     ← groups codes by serial range
      │                    └── Secondary (carton)
      │                         └── Tertiary  (shipper)
      │                              └── Pallette
      ├── Supply Chain Role                   ← "Distributor", "Retailer"
      │    └── Supply Chain User (type 5)
      │         └── Supply Chain Management   ← REQUIRED (see trap #2)
      └── Reward Scheme
           └── Coupon Codes                   ← consumer scratches these

Consumer (type 0)   ← created automatically on first OTP login from the app
Inspector (type 3)  ← created by Admin, then assigned cases
```

**Read it as:** you cannot make a Batch without a Product. You cannot make an
Aggregation without Codes that are already assigned to a Product. You cannot
check in/out without a Supply Chain Management entry.

---

## 2. Two traps that will waste your day

### Trap 1 — Create a Product Template before any Product

`products.template_id` defaults to `1`, and the scan endpoint does this:

```php
$permissions = ProductTemplate::where('id', $code->getProduct->getTemplate->id)->first();
```

There is no null check and `product_templates` ships empty. If no template with
`id = 1` exists, every consumer scan returns a **500**, not a friendly error.

**Do this first:** Vendor dashboard → **Product Template** → Create. That gives
you `id = 1`. Then create products.

### Trap 2 — Creating a Supply Chain User is only half the job

`Supply Chain Users` creates the login (`users.type = 5`). But the scan API
checks a *different* table first:

```php
$check_user = SupplyChain::where('user_id', $id)->first();
if (!$check_user) return 'Unauthorized user.';
```

That row only appears when you add the user under **Supply Chain Managenemt**
(yes, it's spelled that way in the menu). Skip it and every consignment scan
returns "You are not allowed to scan this item."

---

## 3. Step by step

### Phase 0 — Admin

| # | Menu | What to create | Why |
|---|---|---|---|
| 1 | — | Log in as admin | Seeded: `tnt@yopmail.com` / `Admin#123` |
| 2 | **Registrations** | One Vendor (Manufacturer) + Company | This is your brand tenant |
| 3 | **Topups** / **Plans & Credits** | Credits for that vendor | Codes cannot be generated without credit balance |

### Phase 1 — Vendor: make a scannable product

Log out, log back in as the **Vendor**.

| # | Menu | What to create | Notes |
|---|---|---|---|
| 4 | **Product Template** | 1 template | Do this before step 5. See trap #1 |
| 5 | **Products** | 1 product | Set name, brand, price, image, status **Active** |
| 6 | **Batches** | 1 batch under that product | Set mfg date and expiry date — the app shows both |
| 7 | **QR Codes** | Generate 100 codes | Consumes credits. Note the serial range |
| 8 | **QR Codes → assign** | Assign codes to the product + batch | Until assigned, `batch_id` is empty and the app calls it "Deactivated product" |

**Checkpoint — the consumer app now works.** Open the app, log in with any
phone number (OTP is hardcoded to `1111` in dev), scan a code, and you should
see the green "Genuine product" screen with batch and expiry.

### Phase 2 — Supply chain

| # | Menu | What to create | Notes |
|---|---|---|---|
| 9 | **Supply Chain Roles** | `Distributor`, `Retailer` | Just names |
| 10 | **Supply Chain Users** | 2 users | Pick the role; set a phone number you can receive OTP on |
| 11 | **Supply Chain Managenemt** | Add both users to the tree | Manufacturer → Distributor → Retailer. **Do not skip.** See trap #2 |
| 12 | **Aggregations** | Primary, then Secondary | Primary asks for from-serial, to-serial and qty per box |

Aggregation codes look like `P1002026` (Primary), `S1002026` (Secondary).
**That** is the code your supply chain user scans — not the product QR.

**Checkpoint — the supply chain app now works.** Log in as the Distributor,
scan `P1002026`. The server decides whether you can check in or check out and
the app shows one button.

### Phase 3 — Rewards (optional)

| # | Menu | What to create |
|---|---|---|
| 13 | **Rewards** | A reward scheme: points per scan, and items (cash or product) |
| 14 | **Rewards → download** | Coupon codes generated per product code |
| 15 | **Schemes** / **Cashbacks** | Optional lucky-draw style campaigns |

The consumer enters a coupon code in the Rewards tab and points land in their
wallet, scoped to that brand.

### Phase 4 — Inspector / cases

| # | Where | What happens |
|---|---|---|
| 16 | Mobile app (consumer) | Report a product → creates an alert of type `1` |
| 17 | **Alerts** / **App Reports** | Assign the case to an admin or manufacturer user |
| 18 | Mobile app (inspector) | The assigned user sees it in their Cases tab |

Cases only appear for the user they are **assigned to**. An unassigned alert is
invisible to everyone on mobile.

---

## 4. Minimum dataset to demo all four roles

| Thing | Count |
|---|---|
| Vendor + company | 1 |
| Credits | 200+ |
| Product template | 1 |
| Product | 1 |
| Batch | 1 |
| QR codes | 100 (assigned to the product and batch) |
| Supply chain roles | 2 |
| Supply chain users | 2 (both added to Supply Chain Managenemt) |
| Primary aggregation | 2 boxes of 50 |
| Secondary aggregation | 1 carton holding both boxes |
| Reward scheme | 1 |
| Inspector user | 1 |

That is roughly 30 minutes of dashboard work and it exercises every screen in
the app.

---

## 5. Test logins for the app

| Role | How to log in | What you should see |
|---|---|---|
| Consumer | Any phone number, OTP `1111` | Home, Scan, Rewards, History, Profile |
| Supply chain | The phone you set in step 10, OTP `1111` | Home, Scan, Shipments, Alerts, Profile |
| Inspector | Email + password (Password tab) | Home, Cases, Verify, Profile |
| Brand | Vendor email + password | Home, Products, Scans, Alerts, Profile |

OTP is hardcoded to `1111` in `app/Helpers/helpers.php`
(`createOrUpdateUserAndAssignOtp`). Change that before going live.

---

## 6. If something looks empty in the app

| Symptom | Cause |
|---|---|
| Scan returns 500 | No Product Template with `id = 1` (trap #1) |
| "You are not allowed to scan this item" | User missing from Supply Chain Managenemt (trap #2) |
| "Deactivated product scanned" | Code has no `batch_id` — finish step 8 |
| "Product details not found" | Code was never generated, or was seized |
| Consignment scan says invalid code | You scanned the product QR, not the aggregation code |
| Rewards tab empty | No active reward scheme, or scheme dates exclude today |
| Cases tab empty | Alerts exist but are not assigned to that user |
| Brand dashboard all zeros | Logged in as a sub-user whose `parent_id` is not the vendor |
