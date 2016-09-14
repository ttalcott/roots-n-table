	<div class="container">
	<div class="checkbox">
		<label>
			<input type="checkbox" id="farmerCheckbox" value="true" ng-model="checked" aria-label="Toggle ngShow" ng-change="toggleProfileType();" />Farmer
		</label>
	</div>
</div>
<div ng-show="signupData.profileType === 'f' ">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<!--			Form for farmers-->
		<form name="farmerForm" id="farmerForm" ng-submit="submit();">
			<div class="form-group" ng-class="{'has-error': farmerForm.fullName.$touched && farmerForm.fullName.$invalid }">
				<label for="address"></label>
				<input type="text" class="form-control" id="address" placeholder="Address" ng-model="formData.address" ng-minlength="" ng-maxlength="" ng-required="true"/>
			</div>
			<div class="form-group">
				<label for="country"></label>
				<input type="text" class="form-control" id="country" placeholder="Country"/>
			</div>
			<div class="form-group">
				<label for="DOB"></label>
				<input type="text" class="form-control" id="DOB" placeholder="Date of birth"/>
			</div>
			<div class="form-group">
				<label for="InputEmail"></label>
				<input type="email" class="form-control" id="InputEmail" placeholder="Email"/>
			</div>
			<div class="form-group">
				<label for="firstName"></label>
				<input type="text" class="form-control" id="firstName" placeholder="Firstname"/>
			</div>
			<div class="form-group">
				<label for="LastName"></label>
				<input type="text" class="form-control" id="LastName" placeholder="Lastname"/>
			</div>
			<div class="form-group">
				<label for="PhoneNumber"></label>
				<input type="text" class="form-control" id="PhoneNumber" placeholder="Phone Number"/>
			</div>
			<div class="form-group">
				<label for="SSN"></label>
				<input type="text" class="form-control" id="SSN" placeholder="Social Security Number"/>
			</div>
			<div class="form-group">
				<label for="UserName"></label>
				<input type="text" class="form-control" id="UserName" placeholder="User Name"/>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-6">
					<button type="submit" class="btn btn-danger">SIGN UP</button>
				</div>
			</div>
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
					<div class="form-group">
						<label for="textInput"></label>
						<input type="text" class="form-control" id="textInput" placeholder="Firstname"/>
					</div>
					<div class="form-group">
						<label for="textInput"></label>
						<input type="text" class="form-control" id="textInput" placeholder="Lastname"/>
					</div>
					<div class="form-group">
						<label for="textInput"></label>
						<input type="text" class="form-control" id="textInput" placeholder="Username"/>
					</div>
					<div class="form-group">
						<label for="emailInput"></label>
						<input type="email" class="form-control" id="emailInput" placeholder="Email"/>
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
