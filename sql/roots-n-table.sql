
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

CREATE TABLE ledger (
	ledgerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	ledgerPurchaseId INT UNSIGNED NOT NULL,
	ledgerAmount DECIMAL(19,4) NOT NULL,
	ledgerDateTime DATETIME NOT NULL,
	ledgerStripeToken CHAR(28) NOT NULL,
	UNIQUE(ledgerStripeToken),
	INDEX(ledgerPurchaseId),
	FOREIGN KEY(ledgerPurchaseId) REFERENCES purchase(purchaseId),
	PRIMARY KEY(ledgerId)
) ;

CREATE TABLE product(
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productProfileId INT UNSIGNED NOT NULL,
	productUnitId INT UNSIGNED NOT NULL,
	productDescription VARCHAR(256) NOT NULL,
	productName VARCHAR(32) NOT NULL,
	productPrice DECIMAL(19,4) NOT NULL,
	INDEX(productProfileId),
	INDEX(productUnitId),
	FOREIGN KEY(productProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(productUnitId) REFERENCES unit(unitId),
	 PRIMARY KEY(productId)
);

CREATE TABLE unit (
	unitId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	unitName VARCHAR(16) NOT NULL,
	PRIMARY KEY(unitId)
) ;
CREATE TABLE category(
	categoryId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	categoryName VARCHAR(32) NOT NULL,
	PRIMARY KEY(categoryId)
);

CREATE TABLE profileImage (
	profileImageImageId INT UNSIGNED NOT NULL,
	profileImageProfileId INT UNSIGNED NOT NULL,
	INDEX (profileImageImageId),
	INDEX (profileImageProfileId),
	FOREIGN KEY (profileImageImageId) REFERENCES image(imageId),
	FOREIGN KEY (profileImageProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (profileImageImageId, profileImageProfileId)
) ;

CREATE TABLE productImage(
	 productImageImageId INT UNSIGNED NOT NULL,
	productImageProductId INT UNSIGNED NOT NULL,
	 INDEX
	 (productImageImageId),
	 INDEX
	 (productImageProductId),
	 FOREIGN KEY(productImageImageId)REFERENCES image(imageId),
	 FOREIGN KEY(productImageProductId)REFERENCES product(productId),
	 PRIMARY KEY(productImageImageId, productImageProductId)
);

