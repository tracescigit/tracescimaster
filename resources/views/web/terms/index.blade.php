@extends('web.layouts.app')
@section('content')
<div class="main-slider" style="height: 150px; background: transparent linear-gradient( 
45deg , #700877 0%, #ff2759 100%, #ff2759 100%) repeat scroll 0 0;">
</div>
<div class="text-bg" style="font-size: 36px;
color: rgb(209, 86, 136);
padding: 6px 18px 7px;
text-transform: uppercase;
transition: none 0s ease 0s;
line-height: 45px;
border-width: 0px;
margin: 0px auto;
text-align: center;
letter-spacing: 2px;
font-weight: 900;
margin-top: 20px;">Terms of Use
</div>
<div id="main" class="wrapper"> 
	<div class="container" style="padding-top: 20px; padding-bottom: 60px; text-align: justify;">
		<p class="text-gray-600 mb-4 p-6">Please read the following Terms of Use carefully before using our website. With the beginning of the use of our website, the validity of these Terms of Use in the respective version is accepted:
		</p>
		<ul class="text-gray-600">
			<li class="list-style-bullet px-6 p-3">
				Scope : 
				<br>
				The use of the website is subject exclusively to the following conditions. In individual cases, these Terms of Use may be amended, modified or replaced by further conditions, e.g. for the purchase of products and/or services. On the Website we provide users with certain information such as data, texts, logos, layouts, graphics, photos, illustrations, videos, animations, pictures, documents, software and similar material or other information (hereinafter collectively referred to as 'Content') for retrieval or download. 
			</li>
			<li class="list-style-bullet px-6 p-3">
				External Links :
				<br>
				The Website may refer directly or indirectly to external website and contain links to other external website that are not maintained by us. These external website contain information from natural and/or legal persons who are legally independent of and are subject to the liability of the respective website operator. We are neither responsible for the content of these external website and the links listed therein, nor are these contents checked, approved, supported, confirmed or made our own. We have no influence whatsoever on the current and future design of the linked website. The use of external links and external website is at the user's own risk. 
			</li>
			<li class="list-style-bullet px-6 p-3">
				Liability :
				<br>
				The Website have been designed with the utmost care and are regularly updated. Nevertheless, we do not accept any liability for the accuracy, up-to-dateness, correctness, completeness, accuracy, usefulness or usability of the Content contained therein or the freedom from intellectual property rights and other rights of third parties. We do not make any representations regarding the suitability of the Contents of the Website for specific purposes and do not make any guarantees or representations regarding any general or specific characteristics. 
				<br>
				Our liability shall be excluded, unless there is a mandatory liability under the applicable law or in case of intent or gross negligence, injury to life, body or health, the assumption of a guarantee of quality, fraudulent concealment of a defect or breach of essential contractual obligations. However, damages for the breach of essential contractual obligations shall be limited to the foreseeable, typically occurring damages, unless in case of intent or gross negligence. A change in the burden of proof to the detriment of the user shall not be implied hereby. The Content of the Website shall not be deemed to be an offer in the legal sense. We make every effort to keep the Website free of viruses. Nevertheless, we accept no liability that Contents obtained from the user via the Website are free of viruses or harmful components. The user is responsible for ensuring that adequate security precautions and checking mechanisms are in place.  
			</li>
			<li class="list-style-bullet px-6 p-3">
				Trademarks, Copyright and other Rights: 
				<br>
				The Contents of the Website and their arrangement are subject to trademark protection, copyright protection, intellectual property rights or other rights of their respective owners. The user shall observe these rights. 
			</li> 
			<li class="list-style-bullet px-6 p-3">
				Right of Use : 
				<ul> 
					<li class="list-style-circle px-6 p-1">
						The Contents of the Website may not be changed, reproduced, edited, supplemented or otherwise exploited or used without the prior written consent of the respective owner.  
					</li>
					<li class="list-style-circle px-6 p-1">

						To the extent that we expressly make the Content on the Website available for retrieval or download, no written consent shall be required for its use and we hereby grant the user a revocable, non-exclusive, non-transferable, non-assignable and non-sublicensable license to retrieve and download such Content from the Website in accordance with the following terms and conditions: Use shall only be permitted if the copyright notice '© YYYY', or any other copyright notice or appropriate notices referring to intellectual property, remains unchanged on the Content used; and the use of the Contents exclusively serves the informative purpose of the user and / or the use of the Contents corresponds to the purpose intended by us in making the Content available; and no Contents are changed.  
					</li>
					<li class="list-style-circle px-6 p-1">
						The granting of the right of use shall not apply to the use of the design and/or layout of the Website.  
					</li>
					<li class="list-style-circle px-6 p-1">

						We reserve the right to revoke the granting of the right of use at any time. Any use shall be discontinued immediately upon our written request. 
					</li> 
					<li class="list-style-circle px-6 p-1">
						When using the Website, the user shall not cause any damage to or any third parties and shall not violate any applicable law. In particular, the user shall be obliged to comply with the recognised principles of data security 
						<br>
						(e.g. to keep passwords secret) and to prevent the misuse of its own computer systems by third parties. 
					</li>

					<li class="list-style-circle px-6 p-1">

						The granting of the right of use or the use of the Website does not constitute any rights of ownership, license, reproduction, use, protection or other rights by the user, except for the rights expressly granted to the user within the scope of the Terms of Use, nor can any obligation be derived therefrom to grant such rights, regardless of the existence of any intellectual property rights. 
					</li> 
				</ul>
			</li>
			<li class="list-style-bullet px-6 p-3">

				Password and Registration :
				<br>
				Some pages of the Website may be password protected. There is no entitlement to registration. We are entitled to refuse the use our password-protected services for objective reasons or to delete the registration definitively. Objective reasons include in particular the entry or use of false or misleading data or infringements of applicable law.  
			</li>
			<li class="list-style-bullet px-6 p-3">

				Modifications and Amendments :
				<br>
				We reserve the right to amend the Website in whole or in part at any time and without prior notice or to modify or delete the Content of the Website and to discontinue the provision and availability in whole or in part at any time.  
			</li>

			<li class="list-style-bullet px-6 p-3">
				Miscellaneous:
				<br>
				In these Terms of Use and on the Website, the use of other gender variants is generally waived in order to improve readability. Unless the context otherwise requires, all genders are generally meant and implied. In the event that individual provisions of these Terms of Use are invalid, the validity of the remaining provisions shall remain unaffected. Additional agreements require the written form. If the user is a merchant, the exclusive place of jurisdiction shall be RDC. RDC law shall apply.
			</li>

			{{-- <li class="list-style-bullet px-6 p-3">
				CANCELLATION AND REFUND POLICY:
				<br>
				Monotech System Ltd. has not have any cancellation or refund policy. Once the payment has been made on the platform no refunds will be processed.
			</li>

			<li class="list-style-bullet px-6 p-3">
				What if I have any concerns related content / services?
				<br>
				You can always reach out to us through chat box or through mail info@tracesci.in and our team will resolve your issues.
			</li> --}}

			
		</ul>
	</div>
</div>
@endsection