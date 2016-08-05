
CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(28),
	profileEmail VARCHAR(128) NOT NULL,
	profileFirstName VARCHAR (16) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileLastName VARCHAR(16) NOT NULL,
	profilePhoneNumber VARCHAR(32) NULL,
	profileSalt CHAR(64) NOT NULL,
	profileType VARCHAR(8) NOT NULL,
	profileUserName VARCHAR(32) NOT NULL,
	UNIQUE(profileActivationToken),
	UNIQUE(profileEmail),
	UNIQUE(profileHash),
	UNIQUE(profileSalt),
	UNIQUE(profileUserName),
	PRIMARY KEY(profileId)
) ;

CREATE TABLE image(
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imagePath VARCHAR (256)NOT NULL,
	imageType VARCHAR(127) NOT NULL,
	UNIQUE (imagePath),
	PRIMARY KEY (imageId)
);

CREATE TABLE location(
	locationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
 	locationProfileId INT UNSIGNED NOT NULL,
 	locationAttention VARCHAR(32) NULL,
 	locationCity VARCHAR(32) NOT NULL,
 	locationName VARCHAR(32) NOT NULL,
 	locationState VARCHAR(32) NOT NULL,
 	locationStreetOne VARCHAR(128) NOT NULL,
 	locationStretTwo VARCHAR(128) NULL,
 	locationZipCode VARCHAR(10) NOT NULL,
 	INDEX(locationProfileId),
 	FOREIGN KEY(locationProfileId) REFERENCES profile(profileId),
 	PRIMARY KEY(locationId)
 	);

CREATE TABLE purchase(
	purchaseId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	purchasedProfileId INT UNSIGNED NOT NULL,
	purchaseStripeToken CHAR(28) NOT NULL,
	UNIQUE (purchaseStripeToken),
	INDEX (purchasedProfileId),
	FOREIGN KEY (purchasedProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(purchaseId)
);