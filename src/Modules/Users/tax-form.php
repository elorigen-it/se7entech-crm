<?php
    namespace Se7entech\Contractnew\Modules\Users;

    require('../../config/config.php');
    require_once('../../connection.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required{
                color:red;
            }
            .select2-container{
                width:100% !important;
            }
			.section {
				position: relative;
			}

			#booking {
				font-family: 'Montserrat', sans-serif;
				background-image: url('../img/background.jpg');
				background-size: cover;
				background-position: center;
				font-weight: 300;
			}

			.booking-form {
				background: #fff;
				padding: 30px 15px 0px;
				border-radius: 4px;
				overflow: auto;
				width:100%;
			}

			.booking-form .form-group {
				position: relative;
				margin-bottom: 30px;
			}

			.booking-form .form-control {
				border: none;
				-webkit-box-shadow: none;
				box-shadow: none;
				font-size: 12px;
				color: #090a0b;
				font-weight: 300;
				background: #f2f1f1;
				border-radius: 4px;
			}

			.booking-form .form-control::-webkit-input-placeholder {
				color: #b1b6bd;
			}

			.booking-form .form-control:-ms-input-placeholder {
				color: #b1b6bd;
			}

			.booking-form .form-control::placeholder {
				color: #b1b6bd;
			}

			.booking-form input[type="date"].form-control:invalid {
				color: #b1b6bd;
			}

			.booking-form select.form-control {
				-webkit-appearance: none;
				-moz-appearance: none;
				appearance: none;
			}

			.booking-form select.form-control+.select-arrow {
				position: absolute;
				right: 0px;
				top: 0px;
				width: 24px;
				text-align: center;
				pointer-events: none;
				line-height: 65px;
				color: #b1b6bd;
				font-size: 12px;
			}

			.booking-form select.form-control+.select-arrow:after {
				content: '\279C';
				display: block;
				-webkit-transform: rotate(90deg);
				transform: rotate(90deg);
			}

			.booking-form .form-label {
				color: #184c8f;
				display: block;
				font-weight: 600;
				line-height: 25px;
				font-size: 12px;
				position: relative;
				margin-top: 10px;
				text-transform: uppercase;
			}

			/* .booking-form .form-label:after {
				content: '';
				position: absolute;
				left: 10px;
				top: -10px;
				width: 0;
				height: 0;
				border-style: solid;
				border-width: 10px 10px 0 10px;
				border-color: #f2f1f1 transparent transparent transparent;
			} */

			.booking-form .form-btn {
				margin-bottom: 30px;
			}

			.booking-form .submit-btn {
				background: #184c8f;
				border: none;
				font-weight: 600;
				text-transform: uppercase;
				height: 90px;
				font-size: 18px;
				width: 100%;
				color: #fff;
				border-radius: 4px;
				display: block;
			}
			.textarea-default{
				font-size:12px;
				width:100%;
				/* height:150px; */
			}
        </style>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
		<style>
			.accordion-body.ui-accordion-content.ui-corner-bottom.ui-helper-reset.ui-widget-content.ui-accordion-content-active{
				max-height:400px;
			}
			.signature-pad{
				margin: 0 auto;
				display: block;
				border: 1px solid gray;
			}
			.sign-labels{
				text-align: center;
				margin: 0 auto;
				width: 100%;
				font-weight:bold;
				margin-top:1em;
			}
			.button_sign_clear{
				display:block;
				margin:0 auto;
				margin-top:1em;
			}
		</style>
    </head>
    <body class="">
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Updating User <?php echo $this->data['current']['first_name'] . ' ' . $this->data['current']['last_name'];?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Top navbar -->
            <div class="container-fluid mt--7">
			<div class="row align-items-center">
				<div class="col">
					<?php if(count($this->data['session'])):?>
						<?php foreach ($this->data['session'] as $msg)
							echo $msg;    
						?>
					<?php endif;?>
				</div>
			</div>
            <div class="row">
               <div class="col-12">
                    <br />
                    <div class="tab-content" id="tabs">
                        <!-- Tab Managment -->
                        <div class="tab-pane fade show active" id="addzone" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
							<?php if($this->data['current']['role'] == 5 || $this->data['current']['role'] == 6 || $this->data['current']['role'] == 11 || $this->data['current']['role'] == 12 || $this->data['current']['role'] == 14) :?>
							<form action="<?php echo $base_url;?>/modules/users/index.php/update-download-contract/" method="POST">
								<input type="hidden" name="user_id" value="<?php echo $this->data['current']['__user_id'];?>">
								<div class="card bg-secondary shadow">
									<div class="card-header bg-white border-0">
										<div class="row align-items-center">
											<div class="col-12">
												<h3 class="mb-0">User Contract</h3>
												<div class="accordion" id="accordionExample">
													<h3 class="accordion-header" id="headingOne">
													<?php if($this->data['current']['role'] == 5):?>
														Contract for Project Manager
													<?php elseif($this->data['current']['role'] == 6):?>
														Contract for Sales Agent
													<?php elseif($this->data['current']['role'] == 11):?>
														Contract for Content Creator
													<?php elseif($this->data['current']['role'] == 12):?>
														Event Animator
													<?php endif;?>
													<?php elseif($this->data['current']['role'] == 14):?>
														Influencer
													<?php endif;?>
													</h3>
													<?php if($this->data['current']['role'] == 5):?>
														<div class="accordion-body">
															<strong>Employment Agreement for Project Manager</strong>
															<p>This employment agreement ("Agreement") is entered into between  <?php echo $this->data['current']['first_name'] . " " . $this->data['current']['last_name'];?> ("Project Manager") and Se7ench ("Company") as of <?php echo ($this->data['current']['sign_date']) ? $this->data['current']['sign_date'] : $this->data['current']['calculated_date'];?>.</p>
															<p>Description of Employment</p>
															<p>The Project Manager is hired as an employee to perform the position of Project Manager in the Company. Responsibilities will include, but are not limited to:</p>
															<ul>
																<li>Coordinate and supervise the project team, assigning tasks and setting clear goals.</li>
																<li>Plan all stages of the project, defining the scope, creating a schedule and allocating the necessary resources.</li>
																<li>Regularly monitor project progress, identifying deviations and taking corrective action if necessary.</li>
																<li>Manage the scope of the project and any changes that may arise during its development.</li>
																<li>Identify and manage potential project risks.</li>
																<li>Communicate and collaborate with project stakeholders, keeping them informed of progress and making important decisions.</li>
																<li>Efficiently manage project resources, including staff, budget, materials and equipment.</li>
																<li>Resolve problems and challenges that arise during the project, identifying solutions and making decisions.</li>
																<li>Oversee project costs, ensuring that they remain within the established budget.</li>
																<li>Evaluate overall project performance at the end of the project, analyze results and document lessons learned..</li>
															</ul>
															<p>Duties of the Project Manager<br>The Project Manager is committed to:</p>
															<ul>
																<li>Follow up with clients, ensuring that he/she has complete information and introducing him/herself as Project Manager once a sale has been made.</li>
																<li>Establish regular communication with clients to ensure that they are satisfied with the project management.</li>
																<li>Coordinate once a month visits and phone calls or meetings with clients to maintain a strong relationship and establish direct contact.</li>
																<li>Collaborate with the sales team in the closing of contracts and ensure that the established requirements are met.</li>
																<li>Supervise and support the Project Managers under you, ensuring that they fulfill their responsibilities and providing training and guidance when necessary.</li>
															</ul>
															<p>Remuneration</p>
															<ul>
																<li>The Project Manager will receive a 7% commission for each sale made by the salesperson.</li>
																<li>After the first month, the Project Manager will receive 7% of the recurring payments generated by each client.</li>
																<li>The Project Manager will receive 2% commission for each project generated by the Project Managers under his charge.</li>
															</ul>
															<p>Maintenance and Responsibility</p>
															<ul>
																<li>Vendors must promote the sale of recurring maintenance services to customers.</li>
																<li>Maintenance payments will be triggered after the seventh month of tenure with the company.</li>
																<li>The Project Manager will receive a 7% commission on the maintenance payments generated by each client.</li>
															</ul>
															<p>
																Copyright
																<br>
																All projects, audiovisual materials and any work done by The Employee during the employment relationship with The Company shall belong exclusively to The Company. The Employee assigns to The Company the copyrights on such works.
															</p>
															<p>
																Confidentiality
																<br>
																The Employee agrees to keep secret any confidential information of The Company, including information about clients, projects and business plans. The Employee may not use such information for his/her own benefit or for the benefit of third parties.
															</p>
															<p>
																Non-Competition
																<br>
																The Employee agrees not to provide marketing services to The Company's clients for a period of two (2) years after the termination of his/her employment with The Company.
															</p>
															<p>
																Non-Use of Data
																<br>
																The Employee agrees not to use any data obtained from within The Company for personal activities, whether internal or customer information.
															</p>
															<p>
																Duration of the Contract
																<br>
																This contract will have an initial duration of 2 years from the start date. After this period, an evaluation of the Project Manager's performance will be conducted to determine his/her continuity with the Company.
															</p>
															<p>
																Both parties have read, understood and accepted the terms and conditions set forth in this Employment Agreement.
															</p>
															
														</div>
													<?php elseif($this->data['current']['role'] == 6):?>
														<div class="accordion-body" >
															<strong>Employment Agreement for Vendor</strong>
															<p>This employment contract ("Contract") is entered into by <?php echo $this->data['current']['first_name'] . " " . $this->data['current']['last_name'];?> ("Salesperson") and Se7ench ("Company") on the date <?php echo ($this->data['current']['sign_date']) ? $this->data['current']['sign_date'] : $this->data['current']['calculated_date'];?>.</p>
															<p>Job Description</p>
                                                            <ul>
                                                              <li>Collecting business information and converting it into leads.</li>
                                                              <li>Generating clients and following up on sales opportunities.</li>
                                                              <li>Scheduling and attending client meetings.</li>
                                                              <li>Entering information into the Se7entech platform for contract and invoice creation.</li>
                                                              <li>Using the tools available on the Se7entech platform to simplify and improve the sales process.</li>
                                                              <li>Gathering data and information required for projects.</li>
                                                              <li>Reporting progress and client-related activities to the team.</li>
                                                              <li>Taking notes on client interactions.</li>
                                                              <li>Collecting payments from clients according to established agreements.</li>
                                                              <li>Reviewing the potential for upselling opportunities to increase revenue.</li>
                                                              <li>Regularly reporting to the team on all activities and results.</li>
                                                            </ul>
                                                            
                                                            <p>Salesperson Obligations</p>
                                                            <ul>
                                                              <li>Contact a minimum of 10 prospects per day through Google searches or other means.</li>
                                                              <li>Prepare 10 daily reports on prospective businesses.</li>
                                                              <li>Ensure that at least one of the 10 prospected businesses results in a sale per day or one sale per week, as per instructions.</li>
                                                              <li>Conduct thorough research on each prospect online, including searching for the business name and associated keywords, as well as verifying their presence on platforms like Facebook and Instagram.</li>
                                                              <li>Take detailed notes on each client and capture all relevant details, such as the latest social media posts and the existence of a website, indicating whether it was developed by a third-party company.</li>
                                                              <li>Generate a report for each prospect and meet the requirements set for proposal generation in collaboration with the marketing team.</li>
                                                              <li>Coordinate and schedule meetings with the Project Manager and/or the marketing team as necessary.</li>
                                                              <li>Attend meetings and assist in closing contracts.</li>
                                                              <li>Upload all necessary requirements for project development.</li>
                                                              <li>Enter into a “No-Compete” agreement between self and contractor.</li>
                                                            </ul>
                                                            
                                                            <p>Compensation</p>
                                                            <ul>
                                                              <li>The Salesperson will receive 15% but no greater than 25% of the sales they generated.</li>
                                                              <li>After the first month, the Salesperson will receive 5% and no greater than 10% of the recurring amount generated by each client they generate.</li>
                                                              <li>If the Salesperson demonstrates additional skills, such as the ability to shoot videos and create content, and owns the necessary equipment, they can earn $30 but no greater than $45 per hour for photoshoot sessions.</li>
                                                              <li>It is important for the Salesperson to inform clients of all terms and conditions related to the services provided, including payments, timeframes, and general information reflecting the company.</li>
                                                            </ul>
                                                            
                                                            <p>Scalability and Hierarchical Growth Clause for the Salesperson</p>
                                                            <ul>
                                                              <li>Within Se7entech’s structure, the Salesperson will have the opportunity to advance hierarchically based on their sales performance. The levels are defined as follows:</li>
                                                              <li>Level 1 Salesperson: Entry level, with access to a base commission of 15% of their sales generated.</li>
                                                              <li>Level 2 Salesperson: Intermediate level, with access to a base commission of 20% of their sales generated.</li>
                                                              <li>Level 3 Salesperson: Advanced level, with access to a base commission of 25% of their sales generated.</li>
                                                              <li>Transition to Internal Franchise: Once the Salesperson has reached Level 3 and met the sales objectives stipulated by the Company, they will have the option to manage their own team within the Se7entech system under an internal franchise theme. This system will be subject to conditions set out in the Franchise Contract.</li>
                                                              <li>Performance Evaluation: Promotion to each Salesperson level will be subject to periodic performance evaluations by the Company. The Salesperson must meet sales goals and other performance indicators to be eligible for a level promotion or to access the internal franchise theme.</li>
                                                              <li>Salesperson Rights and Obligations: As the Salesperson advances through the hierarchical levels, their profit percentage will increase proportionally, according to the terms set forth in this contract. Additionally, the Salesperson will be responsible for supervising and training their own team members if they opt for the internal franchise, ensuring that the entire team complies with Se7entech’s policies and guidelines.</li>
                                                            </ul>
                                                            
                                                            <p>Work Equipment</p>
                                                            <ul>
                                                              <li>If the Salesperson does not have the necessary required work equipment, the Company may temporarily loan the Salesperson electronic tools or devices, such as a tablet or a laptop, to perform their duties.</li>
                                                              <li>The Salesperson will be responsible for the custody and proper use of the provided equipment or tools. Any loss or damage will be deducted from their compensation.</li>
                                                            </ul>
                                                            
                                                            <p>Copyright</p>
                                                            <ul>
                                                              <li>All projects, audiovisual materials, and any work performed by the Salesperson during their employment with the Company will exclusively belong to the Company. The Salesperson assigns to the Company all copyright to such works.</li>
                                                            </ul>
                                                            
                                                            <p>Confidentiality</p>
                                                            <ul>
                                                              <li>The Salesperson agrees to keep confidential any and all information concerning the Company, including information about clients, projects, and business plans. The Salesperson shall not use such information for personal benefit or the benefit of third parties.</li>
                                                            </ul>
                                                            
                                                            <p>Non-Compete</p>
                                                            <ul>
                                                              <li>The Salesperson agrees not to provide marketing services to the Company’s clients for a period of Three (3) years after the termination of their employment with the Company.</li>
                                                            </ul>
                                                            
                                                            <p>No Use of Data</p>
                                                            <ul>
                                                              <li>The Employee agrees not to use any data obtained within the Company for personal activities, whether it be internal information or client data.</li>
                                                            </ul>
                                                            
                                                            <p>Contract Duration</p>
                                                            <ul>
                                                              <li>This contract will have an initial duration of three months, during which the Salesperson will be on a 90-day probationary timeline. At the end of this period, the Company will evaluate the Salesperson’s performance to determine their continuation with the company.</li>
                                                            </ul>
                                                            
                                                            <p>Both parties have read, understood, and accepted the terms and conditions outlined in this Employment Contract.</p>
															
														</div>
													
													<?php elseif($this->data['current']['role'] == 11):?>
														<div class="accordion-body">
															<strong>Contract of Employment for Content Creator at Se7entech Corp.</strong>
																<p>This employment agreement ("Agreement") is entered into between <?php echo $this->data['current']['first_name'] . " " . $this->data['current']['last_name'];?>("Content Creator") and Se7ench ("Company") as of <?php echo ($this->data['current']['sign_date']) ? $this->data['current']['sign_date'] : $this->data['current']['calculated_date'];?>.</p>
																<p>Job Description. </p>
																<p>The Employee will be hired as a "Content Creator" at Se7entech Corp, and his/her main duties will be the creation of audiovisual content by recording videos and taking photographs based on the planning provided by the Company. The Employee agrees to follow to the letter the planning requirements and specifications given.</p>

																<p>Terms and Conditions:</p>

																<p>1. Content Creation and Supervision: The Employee agrees to create audiovisual content, including videos and photographs, according to the planning provided by the company. The content will be supervised by the Project Manager to determine if it meets the requirements established in the schedule. Photos and videos that are approved by the Project Manager will be eligible for payment.</p>

																<p>2. Payment and Per Diem: The Employee will be paid $30 to $50 per hour for the photo shoot, depending on the length and complexity of the shoot. In addition, transportation per diem will be reimbursed based on the location of the shoot. The Employee must notify the Project Manager when the photos are taken to allow for a thorough review of the content.</p>

																<p>3. Planning Compliance: Employee acknowledges and agrees that strict adherence to the established schedule is critical to the success of projects. In the event Employee fails to comply with the times, dates, locations or other requirements specified in the schedule provided by the Company, the Company reserves the right to withhold payment for missed or poorly executed photo shoot hours. The Company may determine, in its sole discretion, whether or not the failure to meet the schedule is due to good cause. In the event the Employee has a valid reason for failing to comply with the schedule, he/she must notify the Company as far in advance as possible and submit the necessary documentation to support such reason. The decision not to make payment for non-performed photo shoot hours will be communicated in writing to the Employee, along with the reasons and evidence to support this determination.</p>

																<p>4. Copyright: All projects, audiovisual materials and any work performed by The Employee during the employment relationship with The Company, including videos, photographs and other content, shall be the exclusive property of The Company. The Employee assigns to The Company the copyrights and intellectual property rights to such works.</p>

																<p>5. Confidentiality: The Employee agrees to maintain in confidence any confidential information of The Company, including but not limited to information about clients, projects, strategies and business plans. The Employee shall not use such information for his/her own benefit or for the benefit of any third party.</p>

																<p>6. Non-Competition: Employee agrees not to provide marketing services to The Company's clients for two (2) years after termination of employment.</p>

																<p>7. Non-Use of Data: The Employee will not use any data obtained within The Company for personal activities, whether internal or customer information.</p>

																<p>8. Duration of the Contract: This contract will have an initial duration of 2 years from the start date. After this period, the Employee's performance will be evaluated to determine his or her continuation with the Company.</p>

																<p>9. Applicable Law: This contract shall be governed by the laws of the State of Illinois and the regulations of the City of Chicago.</p>

																<p>Both parties have read, understand and agree to the terms and conditions set forth in this Employment Agreement.</p>
														</div>

													<?php elseif($this->data['current']['role'] == 12):?>
														<div class="accordion-body">
															<strong>Employment Agreement for Event Animator</strong>
															<p>Between: </p>
															<p>Se7enTech, hereinafter referred to as "The Company", having its principal place of business at 460 Irving Park Rd Ste C Unit 123, Bensenville, IL 60106, United States. And: <?php echo $this->data['current']['first_name'] . " " . $this->data['current']['last_name'];?> hereinafter referred to as "The Contractor", with a principal address at <?php echo $this->data['current']['address'];?>.</p>
															<p>1. Background </p>
															<p>The Company is engaged in the provision of marketing services, including the organization and management of promotional and entertainment events.</p>
															<p>2. Terms and Conditions:</p>
															<p>2.1 Job Description: The Hirer will perform the role of event entertainer for The Company. The Hired Party will be available to work at regular events, including karaoke events, at a rate of $20 per hour. For weddings and special events, the rate will be $40 per hour. In addition, per diem will be reimbursed at a rate of $0.50 per mile and a meal allowance of $20 per event will be provided.</p>
															<p>2.2 Confidentiality: The Hired Party acknowledges that during the course of his/her work with The Company, he/she may have access to confidential information related to clients, business processes and other confidential data of The Company. The Hired Party agrees to maintain the confidentiality of this information and not to disclose it to any third party at any time or use it for personal gain.</p>
															<p>2.3 Non-Competition: The Contractor agrees not to provide services similar to those offered to The Company for any other competing entity during the term of this contract and for a period of 24 months after its termination.</p>
															<p>3. Payment and Expenses:</p>
															<p>The Company shall pay The Contractor for its services rendered based on the rates and expense reimbursements agreed to in Section 2. Payment shall be made weekly.</p>
															<p>4. Duration of Contract:</p>
															<p>This contract shall be for a period of two years except for the months of January and February from the date of signing. After this period, the contract may be renewed by both parties by mutual written agreement.</p>
															<p>5. Termination:</p>
															<p>Either party may terminate this agreement at any time upon fifteen (15) days written notice. Termination shall not affect the confidentiality and non-competition obligations set forth in this agreement.</p>
															<p>6. Applicable Law:</p>
															<p>This contract shall be governed by and construed in accordance with the laws of the State of Chicago Illinois and the parties agree to submit to the exclusive jurisdiction of the courts of such state or country for the resolution of any dispute arising under this contract.</p>
															<p>This contract is a binding agreement between The Company and The Hired Party and sets forth the terms and conditions of their employment relationship. Both parties must read and fully understand this contract before signing it.</p>
															
														</div>
													<?php elseif($this->data['current']['role'] == 14):?>
														<div class="accordion-body">															
															<strong>Contrato de Prestación de Servicios de Influencer/Modelo</strong>
															<p><strong>Entre:</strong></p>
															<ol>
																<li>Se7entech Corp., con domicilio en Chicago, Illinois, representada por Julio Lopez, en adelante "La Agencia".</li>
																<li><?php echo $this->data['current']['first_name'] . " " . $this->data['current']['last_name'];?>, con domicilio en <?php echo $this->data['current']['address'];?>, en adelante "El Influencer".</li>
															</ol>
															<p><strong>Considerando:</strong></p>
															<ol>
																<li>Que "La Agencia" se dedica a la gestión de marketing para diversas marcas.</li>
																<li>Que "El Influencer" presta servicios de creación de contenido, incluidos videos y fotografías.</li>
																<li>Que ambas partes desean regular los términos y condiciones de su relación laboral.</li>
															</ol>
															<p><strong>Acuerdan lo siguiente:</strong></p>
															<ol>
																<li><strong>Objeto del Contrato:</strong> "El Influencer" se compromete a ceder los derechos de autor de todo el contenido creado en relación con su trabajo para "La Agencia". Esto incluye, pero no se limita a, videos, fotografías y cualquier otro material gráfico o audiovisual.</li>
																<li><strong>Remuneración:</strong>
																	<ul>
																		<li>"El Influencer" recibirá una compensación de $25 USD por hora de trabajo.</li>
																		<li>Además, "La Agencia" cubrirá los viáticos de transporte y comida durante las sesiones de trabajo.</li>
																		<li>En caso de que "El Influencer" genere una venta directa para "La Agencia", recibirá una comisión del 7% - 15% del monto de la venta según sea acordado.</li>
																		<li>Si la venta es de un servicio recurrente, "El Influencer" recibirá un 10% de las ganancias generadas por dicho servicio durante el tiempo que dure la relación con el cliente.</li>
																	</ul>
																</li>
																<li><strong>Beneficios Adicionales:</strong> "La Agencia" se encargará de crear un sitio web para "El Influencer" y gestionar sus redes sociales, si así se requiere.</li>
																<li><strong>Confidencialidad:</strong> "El Influencer" se compromete a guardar estricta confidencialidad sobre toda la información relacionada con "La Agencia" y sus clientes. Cualquier divulgación de dicha información será considerada una violación grave del presente contrato.
																	<p>"El Influencer" no utilizará ningún dato obtenido dentro de la empresa para actividades personales, ya sea información interna o de clientes. Además, se compromete a mantener en secreto cualquier información confidencial de "La Agencia", incluyendo, pero no limitándose a, información sobre clientes, proyectos, estrategias, planes de negocio. "El Influencer" no utilizará dicha información en beneficio propio o de terceros.</p>
																</li>
																<li><strong>Términos Específicos del Trabajo:</strong> Las tareas específicas de "El Influencer" (grabaciones, videos, fotos, etc.) serán detalladas en anexos adicionales a este contrato, según se negocien y acuerden previamente entre las partes.</li>
																<li><strong>Cesión de Derechos:</strong> "El Influencer" cede a "La Agencia" todos los derechos de uso y explotación de su imagen y del contenido creado bajo las pautas proporcionadas por "La Agencia". Esto incluye la autorización para modificar, reproducir y distribuir dicho contenido sin restricción alguna.</li>
																<li><strong>Duración y Terminación:</strong> Este contrato tendrá una duración de 2 años. Cualquiera de las partes puede terminar el contrato con un preaviso de 15 días, salvo que exista una causa justificada para la terminación inmediata.</li>
																<li><strong>Ley Aplicable:</strong> Este contrato se regirá e interpretará de acuerdo con las leyes de la ciudad de Chicago y del estado de Illinois, Estados Unidos.</li>
															</ol>
														</div>
													<?php endif;?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12"> 
												<label class="bolder sign-labels">Signature:</label>
												<canvas id="canvas-signature-agent" class="signature-pad" width="400px" height="200px" >Canvas not supported!</canvas>
												<input name="agent_sign" type="hidden" id="agent_sign" value="<?php echo $this->data['current']['signature'];?>">
												<button <?php echo ($this->data['current']['signature'] == null) ? '' : 'style="display:none"' ?> class="button_sign_clear btn btn-danger btn-sm" id="clear_agent_sign"> <i class="fa fa-eraser" aria-hidden="true"></i> clear</button>
											</div>
										</div>
										<!-- <div class="row">
											<div class="col-sm-12">
												<label>Duracion inicial</label>
												<input class="form-control" disabled name="contract_duration" value="2 years">
											</div>
										</div> -->
										<div class="row">
											<div style="margin: 0 auto;margin-top: 1em;">
												<button class="btn btn-success"><?php echo ($this->data['current']['signature'] == null) ? 'Save and download' : 'Download contract'?></button>
											</div>
										</div>
									</div>
								</div>
							</form>
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0">User Taxes</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
									<!-- <div class="card mt-5" style="width: 18rem;">
										<div class="card-body">
											<h5 class="card-title">Card title</h5>
											<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
											<a href="#" class="btn btn-primary">Go somewhere</a>
										</div>
									</div> -->
                                    <h6 class="heading-small text-muted mb-4">Edit information</h6>
                                    <div class="pl-lg-4">       
                                        <form id="postTax" method="POST" action="<?php echo $base_url;?>/modules/users/index.php/update-download/" enctype="multipart/form-data">
										
										<input type="hidden" name="user_id" value="<?php echo $this->data['current']['__user_id'];?>">
										<div id="booking" class="section">
											<div class="section-center">
												<div class="container">
													<div class="row">
														<div class="booking-form">
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group">
																		<span class="form-label">Payer's info</span>
																		<textarea name="payer_info" rows="4" class="textarea-default" placeholder="PAYER'S name, street address, city or town, state or province, country, ZIP or foreign postal code, and telephone no."><?php echo $this->data['current']['payer_info'] ? $this->data['current']['payer_info'] : '';?></textarea>
																	</div>
																</div>
																<div class="col-md-12">
																	<div class="row">
																		<div class="col-md-6">
																			<span class="form-label">Payer's Tin</span>
																			<input value="<?php echo $this->data['current']['payer_tin'] ? $this->data['current']['payer_tin'] : '';?>" name="payer_tin" type="text" class="form-control">
																		</div>
																		<div class="col-md-6">
																			<span class="form-label">Recipient's Tin</span>
																			<input value="<?php echo $this->data['current']['recipient_tin'] ? $this->data['current']['recipient_tin'] : '';?>" name="recipient_tin" type="text" class="form-control">
																		</div>
																	</div>
																</div>
																<div class="col-md-12">
																	<span class="form-label">Recipient's Name</span>
																	<textarea name="recipient_name" rows="4" class="textarea-default" placeholder="Recipient's name"><?php echo $this->data['current']['recipient_name'] ? $this->data['current']['recipient_name'] : '';?></textarea>
																</div>
																<div class="col-md-12">
																	<span class="form-label">Street Address</span>
																	<textarea name="street_address" rows="4" class="textarea-default" placeholder="Street address (including apt. no.)"><?php echo $this->data['current']['street_address'] ? $this->data['current']['street_address'] : '';?></textarea>
																</div>
																<div class="col-md-12">
																	<span class="form-label">City/Town</span>
																	<textarea name="city_town" rows="4" class="textarea-default" placeholder="City or town, state or province, country, and ZIP or foreign postal code"><?php echo $this->data['current']['city_town'] ? $this->data['current']['city_town'] : '';?></textarea>
																</div>
																<div class="col-md-8">
																	<span class="form-label">Account number</span>
																	<textarea name="account_number" rows="4" class="textarea-default" placeholder="Account number (see instructions)"><?php echo $this->data['current']['account_number'] ? $this->data['current']['account_number'] : '';?></textarea>
																</div>
																<div class="col-md-4">
																	<span class="form-label">2nd TIN not</span>
																	<input <?php echo $this->data['current']['2nd_tin_not'] ?'checked' : '';?> name="2nd_tin_not" type="checkbox">
																</div>

															</div>
															<div class="row">
																<div class="col-md-2">
																	<span class="form-label">1-Rents</span>
																	<input value="<?php echo $this->data['current']['1_rents'] ? $this->data['current']['1_rents'] : '';?>" name="1_rents" type="number" class="form-control">
																</div>
																<div class="col-md-3">
																	<span class="form-label">2-Royalties</span>
																	<input value="<?php echo $this->data['current']['2_royalties'] ? $this->data['current']['2_royalties'] : '';?>" name="2_royalties" type="number" class="form-control">
																</div>
																<div class="col-md-3">
																	<span class="form-label">3-Other income</span>
																	<input value="<?php echo $this->data['current']['3_other_income'] ? $this->data['current']['3_other_income'] : '';?>" name="3_other_income" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">4-Federal income tax withheld</span>
																	<input value="<?php echo $this->data['current']['4_federal_income'] ? $this->data['current']['4_federal_income'] : '';?>" name="4_federal_income" type="number" class="form-control">
																</div>
															</div>

															<div class="row">
																<div class="col-md-4">
																	<span class="form-label">5-Fishing boat proceeds</span>
																	<input value="<?php echo $this->data['current']['5_fishing_boat'] ? $this->data['current']['5_fishing_boat'] : '';?>" name="5_fishing_boat" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">6-Medical and health care payments</span>
																	<input value="<?php echo $this->data['current']['6_medical_health'] ? $this->data['current']['6_medical_health'] : '';?>" name="6_medical_health" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">7- Payer direct sales</span>
																	<input <?php echo $this->data['current']['7_payer_direct'] ? 'checked' : '';?> name="7_payer_direct" type="checkbox">
																	<small> Payer made direct sales totaling $5,000 or more of consumer products to recipient for resale</small>
																</div>
															</div>

															<div class="row">
																<div class="col-md-4">
																	<span class="form-label">8-Substitute payments in lieu of dividends or interest</span>
																	<input value="<?php echo $this->data['current']['8_substitute_payments'] ? $this->data['current']['8_substitute_payments'] : '';?>" name="8_substitute_payments" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">9-Crop insurance proceeds</span>
																	<input value="<?php echo $this->data['current']['9_crop_insurance'] ? $this->data['current']['9_crop_insurance'] : '';?>" name="9_crop_insurance" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">10-  Gross proceeds paid to an attorney</span>
																	<input value="<?php echo $this->data['current']['10_gross_proceeds'] ? $this->data['current']['10_gross_proceeds'] : '';?>" name="10_gross_proceeds" type="number" class="form-control">
																</div>
															</div>

															<div class="row">
																<div class="col-md-4">
																	<span class="form-label">11-Fish purchased for resale</span>
																	<input value="<?php echo $this->data['current']['11_fish_purchased'] ? $this->data['current']['11_fish_purchased'] : '';?>" name="11_fish_purchased" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">12-Section 409A deferrals</span>
																	<input value="<?php echo $this->data['current']['12_section_409a'] ? $this->data['current']['12_section_409a'] : '';?>" name="12_section_409a" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">13-FATCA filing requirement</span>
																	<input <?php echo $this->data['current']['13_fatca_filing'] ? 'checked' : ''?> name="13_fatca_filing" type="checkbox">
																</div>
															</div>

															<div class="row">
																<div class="col-md-4">
																	<span class="form-label">14-Excess golden parachute payments</span>
																	<input value="<?php echo $this->data['current']['14_excess_golden'] ? $this->data['current']['14_excess_golden'] : '';?>" name="14_excess_golden" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">15-Nonqualified deferred compensation</span>
																	<input value="<?php echo $this->data['current']['15_nonqualified_deferred'] ? $this->data['current']['15_nonqualified_deferred'] : '';?>" name="15_nonqualified_deferred" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">16-State tax withheld</span>
																	<input value="<?php echo $this->data['current']['16_state_tax'] ? $this->data['current']['16_state_tax'] : '';?>" name="16_state_tax" type="number" class="form-control" style="border-bottom:2px dotted #184c8f">
																	<input value="<?php echo $this->data['current']['16_state_tax_2'] ? $this->data['current']['16_state_tax_2'] : '';?>" name="16_state_tax_2" type="number" class="form-control">
																</div>
															</div>

															<div class="row">
																<div class="col-md-4">
																	<span class="form-label">17-State/Payer's state no</span>
																	<input value="<?php echo $this->data['current']['17_state_payers_state'] ? $this->data['current']['17_state_payers_state'] : '';?>" name="17_state_payers_state" type="number" class="form-control" style="border-bottom:2px dotted #184c8f">
																	<input value="<?php echo $this->data['current']['17_state_payers_state_2'] ? $this->data['current']['17_state_payers_state_2'] : '';?>" name="17_state_payers_state_2" type="number" class="form-control">
																</div>
																<div class="col-md-4">
																	<span class="form-label">18-State income</span>
																	<input value="<?php echo $this->data['current']['18_state_income'] ? $this->data['current']['18_state_income'] : '';?>" name="18_state_income" type="number" class="form-control" style="border-bottom:2px dotted #184c8f">

																	<input value="<?php echo $this->data['current']['18_state_income_2'] ? $this->data['current']['18_state_income_2'] : '';?>" name="18_state_income_2" type="number" class="form-control">
																</div>
															</div>
															 
															<!-- <div class="col-md-6">
																<div class="form-group">
																	<input class="form-control" type="date" required>
																	<span class="form-label">Check In</span>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<input class="form-control" type="date" required>
																	<span class="form-label">Check out</span>
																</div>
															</div> -->
															<div class="row">
																<div class="col-md-4 mt-4">
																	<button class="btn btn-success">Save and download</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
                                        </form>
                                    </div>
								</div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
         </div>
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
        </div>
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>  
		<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
		<script>
			$( function() {
				$( "#accordionExample" ).accordion({
					collapsible: true,
					autoHeight: false
				});

				//signatures
                var signature_agent = new SignaturePad(document.getElementById('canvas-signature-agent'), {
                    backgroundColor: 'white',
                    penColor: 'black'
                });
                signature_agent.addEventListener('endStroke', (e) => {
                    document.querySelector('#agent_sign').value = e.target.toDataURL();
                })
                document.querySelector('#clear_agent_sign').addEventListener('click', (e) => {
                    e.preventDefault();
                    signature_agent.clear();
                    document.querySelector('#agent_sign').value = signature_agent.toDataURL();
                })
				<?php if($this->data['current']['signature']):?>
					signature_agent.fromDataURL("<?php echo $this->data['current']['signature'];?>")
				<?php endif;?>
				
			} );
		</script>
    </body>
</html>