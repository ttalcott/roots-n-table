<!-- select account type -->
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1>Sign Up Today</h1>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="farmerCheckbox" name="farmerCheckbox" value="true" ng-model="checked"
							 aria-label="Toggle ngShow"
							 ng-change="toggleProfileType();"/>Check here to create a Seller Account.
				</label>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<!-- begin user form -->
	<form name="userForm" id="userForm" ng-submit="submit(formData, userForm.$valid);" ng-show="signupData.profileType === 'u'">

		<!-- first name -->
		<div class="form-group" ng-class="{'has-error': userForm.profileFirstName.$touched && userForm.profileFirstName.$invalid}">
			<label for="profileFirstName">First Name</label>
			<input id="profileFirstName" name="profileFirstName" type="text" class="form-control" ng-model="formData.profileFirstName" ng-minlength="1" ng-maxlength="32" ng-required="true"/>
		</div>

		<!-- last name -->
		<div class="form-group" ng-class="{'has-error': userForm.profileLastName.$touched && userForm.profileLastName.$invalid}">
			<label for="lastName">Last Name</label>
			<input id="profileLastName" name="profileLastName" type="text" class="form-control" ng-model="formData.profileLastName" ng-minlength="1" ng-maxlength="64" ng-required="true" />
		</div>

		<!-- email -->
		<div class="form-group" ng-class="{'has-error': userForm.profileEmail.$touched && userForm.profileEmail.$invalid}">
			<label for="profileEmail">Email</label>
			<input id="profileEmail" name="profileEmail" type="email" class="form-control" ng-model="formData.profileEmail" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
		</div>

		<!-- username -->
		<div class="form-group" ng-class="{'has-error': userForm.profileUserName.$touched && userForm.profileUserName.$invalid}">
			<label for="profileUserName">Username</label>
			<input id="profileUserName" name="profileUserName" type="text" class="form-control" ng-model="formData.profileUserName" ng-minlength="1" ng-maxlength="32" ng-required="true" />
		</div>

		<!-- pass -->
		<div class="form-group" ng-class="{'has-error': userForm.password.$touched && userForm.password.$invalid}">
			<label for="password">Password</label>
			<input id="password" name="password" type="password" class="form-control" ng-model="formData.password" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
		</div>

		<!-- confirm pass -->
		<div class="form-group" ng-class="{'has-error': userForm.confirmPassword.$touched && userForm.confirmPassword.$invalid}">
			<label for="confirmPass">Confirm Password</label>
			<input id="confirmPassword" name="confirmPassword" type="password" class="form-control" ng-model="formData.confirmPassword" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
		</div>

		<!-- submit button -->
		<button type="submit" class="btn btn-danger">Submit</button>
	</form>

	<!-- begin farmer form -->
	<form name="farmerForm" id="farmerForm" ng-submit="submit(formData, farmerForm.$valid);" ng-show="signupData.profileType === 'f'">
		<!-- first name -->
		<div class="form-group" ng-class="{'has-error': farmerForm.profileFirstName.$touched && farmerForm.profileFirstName.$invalid}">
			<label for="profileFirstName">First Name Foo!</label>
			<input id="profileFirstName" name="profileFirstName" type="text" class="form-control" ng-model="formData.profileFirstName" ng-minlength="1" ng-maxlength="32" ng-required="true"/>
		</div>

		<!-- last name -->
		<div class="form-group" ng-class="{'has-error': farmerForm.profileLastName.$touched && farmerForm.profileLastName.$invalid}">
			<label for="lastName">Last Name</label>
			<input id="profileLastName" name="profileLastName" type="text" class="form-control" ng-model="formData.profileLastName" ng-minlength="1" ng-maxlength="64" ng-required="true" />
		</div>

		<!-- email -->
		<div class="form-group" ng-class="{'has-error': farmerForm.profileEmail.$touched && farmerForm.profileEmail.$invalid}">
			<label for="profileEmail">Email</label>
			<input id="profileEmail" name="profileEmail" type="email" class="form-control" ng-model="formData.profileEmail" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
		</div>

		<!-- username -->
		<div class="form-group" ng-class="{'has-error': farmerForm.profileUserName.$touched && farmerForm.profileUserName.$invalid}">
			<label for="profileUserName">Username</label>
			<input id="profileUserName" name="profileUserName" type="text" class="form-control" ng-model="formData.profileUserName" ng-minlength="1" ng-maxlength="32" ng-required="true" />
		</div>

		<!-- pass -->
		<div class="form-group" ng-class="{'has-error': farmerForm.password.$touched && farmerForm.password.$invalid}">
			<label for="password">Password</label>
			<input id="password" name="password" type="password" class="form-control" ng-model="formData.password" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
		</div>

		<!-- confirm pass -->
		<div class="form-group" ng-class="{'has-error': farmerForm.confirmPassword.$touched && farmerForm.confirmPassword.$invalid}">
			<label for="confirmPass">Confirm Password</label>
			<input id="confirmPassword" name="confirmPassword" type="password" class="form-control" ng-model="formData.confirmPassword" ng-minlength="1" ng-maxlength="128" ng-required="true"/>
		</div>
	</form>
</div>


