<div class="container">
	<div class="checkbox">
		<label>
			<input type="checkbox" id="farmerCheckbox" name="farmerCheckbox" value="true" ng-model="checked" aria-label="Toggle ngShow"
					 ng-change="toggleProfileType();"/>Farmer
		</label>
	</div>
</div>
<div ng-show="signupData.profileType === 'f' ">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<!--			Form for farmers-->
		<form name="farmerForm" id="farmerForm" ng-submit="submit(formData, farmerForm.$valid);">
			<div class="form-group" ng-class="{'has-error': farmerForm.address.$touched && farmerForm.address.$invalid }">
				<label for="address">Address</label>
				<input type="text" class="form-control" id="address" name="address" placeholder="Address" ng-model="formData.address"
						 ng-minlength="8" ng-maxlength="256" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="farmerForm.address.$error"
				  ng-if="farmerForm.address.$touched" ng-hide="farmerForm.address.$valid">
				<p ng-message="minlength">Address is too short.</p>
				<p ng-message="maxlength">Address is too long.</p>
				<p ng-message="required">Please enter your address.</p>
			</div>
			<div class="form-group" ng-class="{'has-error': farmerForm.country.$touched && farmerForm.country.$invalid }">
				<label for="country">Country</label>
				<input type="text" class="form-control" id="country" name="country" placeholder="Country" ng-model="formData.country"
						 ng-minlength="2" ng-maxlength="8" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="farmerForm.country.$error"
				  ng-if="farmerForm.country.$touched" ng-hide="farmerForm.country.$valid">
				<p ng-message="minlength">Country is too short.</p>
				<p ng-message="maxlength">Country is too long.</p>
				<p ng-message="required">Please enter your Country.</p>
			</div>
			<div class="form-group"
				  ng-class="{'has-error': farmerForm.dateOfBirth.$touched && farmerForm.dateOfBirth.$invalid }">
				<label for="dateOfBirth">Date of birth</label>
				<input type="text" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Date Of Birth"
						 ng-model="formData.dateOfBirth" ng-minlength="8" ng-maxlength="8" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="farmerForm.dateOfBirth.$error"
				  ng-if="farmerForm.dateOfBirth.$touched" ng-hide="farmerForm.dateOfBirth.$valid">
				<p ng-message="minlength">Date of birth is too short.</p>
				<p ng-message="maxlength">Date of birth is too long.</p>
				<p ng-message="required">Please enter your date of birth.</p>
			</div>
	</div>
	<div class="form-group" ng-class="{'has-error': farmerForm.email.$touched && farmerForm.email.$invalid }">
		<label for="email">Email</label>
		<input type="text" class="form-control" id="email" name="email" placeholder="Email" ng-model="formData.email" ng-minlength="8"
				 ng-maxlength="128" ng-required="true"/>
	</div>
	<div class="alert alert-danger" role="alert" ng-messages="farmerForm.email.$error" ng-if="farmerForm.email.$touched"
		  ng-hide="farmerForm.email.$valid">
		<p ng-message="minlength">Email is too short.</p>
		<p ng-message="maxlength">Email is too long.</p>
		<p ng-message="required">Please enter your email.</p>
	</div>
	<div class="form-group" ng-class="{'has-error': farmerForm.firstName.$touched && farmerForm.firstName.$invalid }">
		<label for="firstName">Firstname</label>
		<input type="text" class="form-control" id="firstName" name="firstName" placeholder="FirstName" ng-model="formData.firstName"
				 ng-minlength="1" ng-maxlength="32" ng-required="true"/>
	</div>
	<div class="alert alert-danger" role="alert" ng-messages="farmerForm.firstName.$error"
		  ng-if="farmerForm.firstName.$touched" ng-hide="farmerForm.firstName.$valid">
		<p ng-message="minlength">Firstname is too short.</p>
		<p ng-message="maxlength">Firstname is too long.</p>
		<p ng-message="required">Please enter your firstname.</p>
	</div>
	<div class="form-group" ng-class="{'has-error': farmerForm.lastName.$touched && farmerForm.lastName.$invalid }">
		<label for="lastName">Lastname</label>
		<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Lastname" ng-model="formData.lastName"
				 ng-minlength="1" ng-maxlength="64" ng-required="true"/>
	</div>
	<div class="alert alert-danger" role="alert" ng-messages="farmerForm.lastName.$error"
		  ng-if="farmerForm.lastName.$touched" ng-hide="farmerForm.lastName.$valid">
		<p ng-message="minlength">Lastname is too short.</p>
		<p ng-message="maxlength">Lastname is too long.</p>
		<p ng-message="required">Please enter your lastname.</p>
	</div>
	<div class="form-group"
		  ng-class="{'has-error': farmerForm.phoneNumber.$touched && farmerForm.phoneNumber.$invalid }">
		<label for="phoneNumber">Phone number</label>
		<input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone number"
				 ng-model="formData.phoneNumber" ng-minlength="9" ng-maxlength="256"/>
	</div>
	<div class="alert alert-danger" role="alert" ng-messages="farmerForm.phoneNumber.$error"
		  ng-if="farmerForm.phoneNumber.$touched" ng-hide="farmerForm.phoneNumber.$valid">
		<p ng-message="minlength">Phone number is too short.</p>
		<p ng-message="maxlength">Phone number is too long.</p>
		<p ng-message="required">Please enter your phone number.</p>
	</div>
	<div class="form-group" ng-class="{'has-error': farmerForm.ssn.$touched && farmerForm.ssn.$invalid }">
		<label for="ssn">Social Security Number</label>
		<input type="text" class="form-control" id="ssn" name="ssn" placeholder="Social Security Number" ng-model="formData.ssn"
				 ng-minlength="8" ng-maxlength="256" ng-required="true"/>
	</div>
	<div class="alert alert-danger" role="alert" ng-messages="farmerForm.ssn.$error" ng-if="farmerForm.ssn.$touched"
		  ng-hide="farmerForm.ssn.$valid">
		<p ng-message="minlength">Social Security Number is too short.</p>
		<p ng-message="maxlength">Social Security Number is too long.</p>
		<p ng-message="required">Please enter your Social Security Number.</p>
	</div>
	<div class="form-group" ng-class="{'has-error': farmerForm.userName.$touched && farmerForm.userName.$invalid }">
		<label for="userName">Username</label>
		<input type="text" class="form-control" id="userName" name="userName" placeholder="Username" ng-model="formData.userName"
				 ng-minlength="8" ng-maxlength="32" ng-required="true"/>
	</div>
	<div class="alert alert-danger" role="alert" ng-messages="farmerForm.userName.$error"
		  ng-if="farmerForm.userName.$touched" ng-hide="farmerForm.userName.$valid">
		<p ng-message="minlength">Username is too short.</p>
		<p ng-message="maxlength">Username is too long.</p>
		<p ng-message="required">Please enter your username.</p>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-6">
			<button type="submit" class="btn btn-danger">SIGN UP</button>
		</div>
	</div>
	<uib-alert ng-repeat="alert in alerts" type="" close="alerts.length = 0;"></uib-alert>
	</form>
</div>
</div>
<div class="col-md-2"></div>


<!--		Form for users-->
<div ng-show="signupData.profileType === 'u' ">
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form class="form-horizontal" ng-submit="submit();">
					<div class="form-group" ng-class="{'has-error': userForm.firstName.$touched && userForm.firstName.$invalid }">
						<label for="firstName">Firstname</label>
						<input type="text" class="form-control" id="firstName" name="firstName" placeholder="Firstname" ng-model="formData.firstName"
								 ng-minlength="1" ng-maxlength="32" ng-required="true"/>
					</div>
					<div class="alert alert-danger" role="alert" ng-messages="userForm.firstName.$error"
						  ng-if="userForm.firstName.$touched" ng-hide="userForm.firstName.$valid">
						<p ng-message="minlength">Firstname is too short.</p>
						<p ng-message="maxlength">Firstname is too long.</p>
						<p ng-message="required">Please enter your firstname.</p>
					</div>
					</div>
			<div class="form-group" ng-class="{'has-error': userForm.lastName.$touched && userForm.lastName.$invalid }">
				<label for="lastName">Lastname</label>
				<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Lastname" ng-model="formData.lastName"
						 ng-minlength="1" ng-maxlength="64" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="userForm.firstName.$error"
				  ng-if="userForm.lastName.$touched" ng-hide="userForm.lastName.$valid">
				<p ng-message="minlength">Lastname is too short.</p>
				<p ng-message="maxlength">Lastname is too long.</p>
				<p ng-message="required">Please enter your lastname.</p>
			</div>
			<div class="form-group" ng-class="{'has-error': userForm.email.$touched && userForm.email.$invalid }">
				<label for="email">Email</label>
				<input type="text" class="form-control" id="email" name="email" placeholder="Email" ng-model="formData.email"
						 ng-minlength="1" ng-maxlength="32" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="userForm.email.$error" ng-if="userForm.email.$touched" ng-hide="userForm.email.$valid">
				<p ng-message="minlength">Email is too short.</p>
				<p ng-message="maxlength">Email is too long.</p>
				<p ng-message="required">Please enter your email.</p>
			</div>
			<div class="form-group" ng-class="{'has-error': userForm.userName.$touched && userForm.userName.$invalid }">
				<label for="userName">Username</label>
				<input type="text" class="form-control" id="userName" name="userName" placeholder="Username" ng-model="formData.userName"
						 ng-minlength="8" ng-maxlength="128" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="userForm.userName.$error" ng-if="userForm.userName.$touched" ng-hide="userForm.userName.$valid">
				<p ng-message="minlength">Username is too short.</p>
				<p ng-message="maxlength">Username is too long.</p>
				<p ng-message="required">Please enter your username.</p>
			</div>
					<div class="form-group">
						<div class="col-sm-offset-6">
							<button type="submit" class="btn btn-danger">SIGN UP</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
</div>
