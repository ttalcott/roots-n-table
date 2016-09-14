<!-- select account type -->
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1>Sign Up Today</h1>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="farmerCheckbox" name="farmerCheckbox" value="true" ng-model="checked"
							 aria-label="Toggle ngShow"
							 ng-change="toggleProfileType();"/>Check here to create a Seller (Farmer) Account.
				</label>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<!-- begin user form -->
	<form name="userForm" id="userForm" ng-submit="submit(formData, userForm.$valid);"
			ng-show="signupData.profileType === 'u'" novalidate>

		<div class="row">
			<div class="col-md-6">
				<!-- first name -->
				<div class="form-group"
					  ng-class="{'has-error': userForm.profileFirstName.$touched && userForm.profileFirstName.$invalid}">
					<label for="profileFirstName">First Name</label>
					<input id="profileFirstName" name="profileFirstName" type="text" class="form-control"
							 ng-model="formData.profileFirstName" ng-minlength="1" ng-maxlength="32" ng-required="true"/>

					<!-- input error handling -->
					<div class="alert alert-danger" role="alert" ng-messages="userForm.profileFirstName.$error"
						  ng-if="userForm.profileFirstName.$touched" ng-hide="userForm.profileFirstName.$valid">
						<p ng-message="minlength">First name is too short.</p>
						<p ng-message="maxlength">First Name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
				</div>

				<!-- last name -->
				<div class="form-group"
					  ng-class="{'has-error': userForm.profileLastName.$touched && userForm.profileLastName.$invalid}">
					<label for="lastName">Last Name</label>
					<input id="profileLastName" name="profileLastName" type="text" class="form-control"
							 ng-model="formData.profileLastName" ng-minlength="1" ng-maxlength="64" ng-required="true"/>

					<!-- input error handling -->
					<div class="alert alert-danger" role="alert" ng-messages="userForm.profileFirstName.$error"
						  ng-if="userForm.profileFirstName.$touched" ng-hide="userForm.profileFirstName.$valid">
						<p ng-message="minlength">First name is too short.</p>
						<p ng-message="maxlength">First Name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
				</div>

				<!-- email -->
				<div class="form-group"
					  ng-class="{'has-error': userForm.profileEmail.$touched && userForm.profileEmail.$invalid}">
					<label for="profileEmail">Email</label>
					<input id="profileEmail" name="profileEmail" type="email" class="form-control" ng-model="formData.profileEmail"
							 ng-minlength="1" ng-maxlength="128" ng-required="true"/>

					<!-- input error handling -->
					<div class="alert alert-danger" role="alert" ng-messages="userForm.profileFirstName.$error"
						  ng-if="userForm.profileFirstName.$touched" ng-hide="userForm.profileFirstName.$valid">
						<p ng-message="minlength">First name is too short.</p>
						<p ng-message="maxlength">First Name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
				</div>

				<!-- username -->
				<div class="form-group"
					  ng-class="{'has-error': userForm.profileUserName.$touched && userForm.profileUserName.$invalid}">
					<label for="profileUserName">Username</label>
					<input id="profileUserName" name="profileUserName" type="text" class="form-control"
							 ng-model="formData.profileUserName" ng-minlength="1" ng-maxlength="32" ng-required="true"/>

					<!-- input error handling -->
					<div class="alert alert-danger" role="alert" ng-messages="userForm.profileFirstName.$error"
						  ng-if="userForm.profileFirstName.$touched" ng-hide="userForm.profileFirstName.$valid">
						<p ng-message="minlength">First name is too short.</p>
						<p ng-message="maxlength">First Name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
				</div>

				<!-- pass -->
				<div class="form-group" ng-class="{'has-error': userForm.password.$touched && userForm.password.$invalid}">
					<label for="password">Password</label>
					<input id="password" name="password" type="password" class="form-control" ng-model="formData.password"
							 ng-minlength="1" ng-maxlength="128" ng-required="true"/>
				</div>

				<!-- confirm pass -->
				<div class="form-group"
					  ng-class="{'has-error': userForm.confirmPassword.$touched && userForm.confirmPassword.$invalid}">
					<label for="confirmPass">Confirm Password</label>
					<input id="confirmPassword" name="confirmPassword" type="password" class="form-control"
							 ng-model="formData.confirmPassword" ng-minlength="1" ng-maxlength="128" ng-required="true"/>

					<!-- input error handling -->
					<div class="alert alert-danger" role="alert" ng-messages="userForm.profileFirstName.$error"
						  ng-if="userForm.profileFirstName.$touched" ng-hide="userForm.profileFirstName.$valid">
						<p ng-message="minlength">First name is too short.</p>
						<p ng-message="maxlength">First Name is too long.</p>
						<p ng-message="required">Please enter your first name.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<!-- submit button -->
				<button type="submit" class="btn btn-danger">Submit</button>
			</div>
		</div>
	</form>

	<!-- begin farmer form -->
	<form name="farmerForm" id="farmerForm" ng-submit="submit(formData, farmerForm.$valid);"
			ng-show="signupData.profileType === 'f'" novalidate>
		<div class="row">
			<div class="col-md-6">
				<!-- first name -->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.profileFirstName.$touched && farmerForm.profileFirstName.$invalid}">
					<label for="profileFirstName">First Name</label>
					<input id="profileFirstName" name="profileFirstName" type="text" class="form-control"
							 ng-model="formData.profileFirstName" ng-minlength="1" ng-maxlength="32" ng-required="true"/>
				</div>

				<!-- last name -->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.profileLastName.$touched && farmerForm.profileLastName.$invalid}">
					<label for="lastName">Last Name</label>
					<input id="profileLastName" name="profileLastName" type="text" class="form-control"
							 ng-model="formData.profileLastName" ng-minlength="1" ng-maxlength="64" ng-required="true"/>
				</div>

				<!-- email -->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.profileEmail.$touched && farmerForm.profileEmail.$invalid}">
					<label for="profileEmail">Email</label>
					<input id="profileEmail" name="profileEmail" type="email" class="form-control"
							 ng-model="formData.profileEmail" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
				</div>

				<!-- username -->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.profileUserName.$touched && farmerForm.profileUserName.$invalid}">
					<label for="profileUserName">Username</label>
					<input id="profileUserName" name="profileUserName" type="text" class="form-control"
							 ng-model="formData.profileUserName" ng-minlength="1" ng-maxlength="32" ng-required="true"/>
				</div>

				<!-- pass -->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.password.$touched && farmerForm.password.$invalid}">
					<label for="password">Password</label>
					<input id="password" name="password" type="password" class="form-control" ng-model="formData.password"
							 ng-minlength="1" ng-maxlength="128" ng-required="true"/>
				</div>

				<!-- confirm pass -->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.confirmPassword.$touched && farmerForm.confirmPassword.$invalid}">
					<label for="confirmPass">Confirm Password</label>
					<input id="confirmPassword" name="confirmPassword" type="password" class="form-control"
							 ng-model="formData.confirmPassword" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
				</div>
			</div><!--/.col-md-6-->

			<!-- form column 2-->
			<div class="col-md-6">
				<!-- address -->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.profileAddressLineOne.$touched && farmerForm.profileAddressLineOne.$invalid}">
					<label for="profileAddressLineOne">Address</label>
					<input id="profileAddressLineOne" name="profileAddressLineOne" type="text" class="form-control"
							 ng-model="formData.profileAddressLineOne" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
				</div>

				<div class="row">
					<div class="col-md-6">
						<!-- city -->
						<div class="form-group"
							  ng-class="{'has-error': farmerForm.profileAddressCity.$touched && farmerForm.profileAddressCity.$invalid}">
							<label for="profileAddressCity">City</label>
							<input id="profileAddressCity" name="profileAddressCity" type="text" class="form-control"
									 ng-model="formData.profileAddressCity" ng-minlength="1" ng-maxlength="32"
									 ng-required="true"/>
						</div>
					</div>
					<div class="col-md-6">
						<!-- state -->
						<div class="form-group"
							  ng-class="{'has-error': farmerForm.profileAddressState.$touched && farmerForm.profileAddressState.$invalid}">
							<label for="profileAddressState">State</label>
							<select name="profileAddressState" id="profileAddressState" class="form-control"
									  ng-model="formData.profileAddressState" ng-required="true">
								<?php require_once(dirname(__DIR__, 2) . "/php/partials/states.php"); ?>
							</select>
							<!-- <input id="profileAddressState" name="profileAddressState" type="text" class="form-control" ng-model="formData.profileAddressState" ng-minlength="1" ng-maxlength="32" ng-required="true"/> -->
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<!-- country -->
						<div class="form-group"
							  ng-class="{'has-error': farmerForm.profileCountry.$touched && farmerForm.profileCountry.$invalid}">
							<label for="profileCountry">Country</label>
							<input id="profileCountry" name="profileCountry" type="text" class="form-control"
									 ng-model="formData.profileCountry" ng-minlength="1" ng-maxlength="32" ng-required="true"/>
						</div>
					</div>
					<div class="col-md-6">
						<!-- zip -->
						<div class="form-group"
							  ng-class="{'has-error': farmerForm.profileAddressZip.$touched && farmerForm.profileAddressZip.$invalid}">
							<label for="profileAddressZip">Zip Code</label>
							<input id="profileAddressZip" name="profileAddressZip" type="text" class="form-control"
									 ng-model="formData.profileAddressZip" ng-minlength="1" ng-maxlength="11"
									 ng-required="true"/>
						</div>
					</div>
				</div><!--/.row-->

				<div class="row">
					<div class="col-md-6">
						<!-- phone -->
						<div class="form-group"
							  ng-class="{'has-error': farmerForm.profilePhone.$touched && farmerForm.profilePhone.$invalid}">
							<label for="profilePhone">Phone</label>
							<input id="profilePhone" name="profilePhone" type="tel" class="form-control"
									 ng-model="formData.profilePhone" ng-minlength="1" ng-maxlength="32"/>
						</div>
					</div>
					<div class="col-md-6">
						<!--		dob-->
						<div class="form-group"
							  ng-class="{'has-error': farmerForm.profileDateOfBirth.$touched && farmerForm.profileDateOfBirth.$invalid}">
							<label for="profileDateOfBirth">Date of birth</label>
							<input id="profileDateOfBirth" name="profileDateOfBirth" type="text" class="form-control"
									 ng-model="formData.profileDateOfBirth" ng-minlength="1" ng-maxlength="11" ng-required="true"/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Select an Account Type</label>
					<div class="radio">
						<label>
							<input type="radio" name="profileBusinessOrIndividual" id="profileBusinessOrIndividual" value="b" selected="true">
							"Business"
						</label>
					</div>
					<div class="radio">
						<label for="">
							<input type="radio" name="profileBusinessOrIndividual" id="blankRadio1" value="i" >
							"Individual"
						</label>
					</div>
				</div>

				<!--		bank acct number-->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.profileBankAccountNumber.$touched && farmerForm.profileBankAccountNumber.$invalid}">
					<label for="profileBankAccountNumber">Bank Account Number</label>
					<input id="profileBankAccountNumber" name="profileBankAccountNumber" type="text" class="form-control"
							 ng-model="formData.profileBankAccountNumber" ng-minlength="1" ng-maxlength="64" ng-required="true"/>
				</div>
				<!--		bank rtng number-->
				<div class="form-group"
					  ng-class="{'has-error': farmerForm.profileBankRoutingNumber.$touched && farmerForm.profileBankRoutingNumber.$invalid}">
					<label for="profileBankRoutingNumber">Bank Account Routing Number</label>
					<input id="profileBankRoutingNumber" name="profileBankRoutingNumber" type="text" class="form-control"
							 ng-model="formData.profileBankRoutingNumber" ng-minlength="1" ng-maxlength="64" ng-required="true"/>
				</div>

			</div><!--/.col-md-6-->
		</div><!--/.row-->

		<div class="row">
			<div class="col-xs-12">
				<!-- submit button -->
				<button type="submit" class="btn btn-danger">Submit</button>
			</div>
		</div>

	</form>
</div>


