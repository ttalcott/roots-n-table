
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
	PRIMARY KEY (imageId),
);
