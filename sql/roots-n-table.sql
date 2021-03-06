DROP TABLE IF EXISTS profileImage;
DROP TABLE IF EXISTS productPurchase;
DROP TABLE IF EXISTS productImage;
DROP TABLE IF EXISTS productCategory;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS ledger;
DROP TABLE IF EXISTS purchase;
DROP TABLE IF EXISTS unit;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profileFirstName VARCHAR(32) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileLastName VARCHAR(64) NOT NULL,
	profilePhoneNumber VARCHAR(32) NULL,
	profileSalt CHAR(64) NOT NULL,
	profileStripeToken VARCHAR(32) NULL,
	profileType CHAR(1) NOT NULL,
	profileUserName VARCHAR(32) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileUserName),
	PRIMARY KEY(profileId)
) ;

CREATE TABLE category(
	categoryId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	categoryName VARCHAR(32) NOT NULL,
	PRIMARY KEY(categoryId)
);

CREATE TABLE image(
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imagePath VARCHAR(255) NOT NULL,
	imageType VARCHAR(10) NOT NULL,
	UNIQUE (imagePath),
	PRIMARY KEY (imageId)
);

CREATE TABLE unit (
	unitId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	unitName VARCHAR(16) NOT NULL,
	PRIMARY KEY(unitId)
) ;

CREATE TABLE purchase(
	purchaseId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	purchaseProfileId INT UNSIGNED NOT NULL,
	purchaseStripeToken CHAR(28) NOT NULL,
	UNIQUE (purchaseStripeToken),
	INDEX (purchaseProfileId),
	FOREIGN KEY (purchaseProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(purchaseId)
);

CREATE TABLE ledger (
	ledgerId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	ledgerPurchaseId INT UNSIGNED NOT NULL,
	ledgerAmount DECIMAL(12,2) NOT NULL,
	ledgerDateTime DATETIME NOT NULL,
	ledgerStripeToken CHAR(28) NOT NULL,
	UNIQUE(ledgerStripeToken),
	INDEX(ledgerPurchaseId),
	FOREIGN KEY(ledgerPurchaseId) REFERENCES purchase(purchaseId),
	PRIMARY KEY(ledgerId)
) ;

CREATE TABLE location(
	locationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
 	locationProfileId INT UNSIGNED NOT NULL,
 	locationAttention VARCHAR(32) NULL,
 	locationCity VARCHAR(32) NOT NULL,
 	locationName VARCHAR(32) NOT NULL,
 	locationState VARCHAR(32) NOT NULL,
 	locationStreetOne VARCHAR(128) NOT NULL,
 	locationStreetTwo VARCHAR(128) NULL,
 	locationZipCode VARCHAR(10) NOT NULL,
 	INDEX(locationProfileId),
 	FOREIGN KEY(locationProfileId) REFERENCES profile(profileId),
 	PRIMARY KEY(locationId)
);

CREATE TABLE product(
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productProfileId INT UNSIGNED NOT NULL,
	productUnitId INT UNSIGNED NOT NULL,
	productDescription VARCHAR(255) NOT NULL,
	productName VARCHAR(64) NOT NULL,
	productPrice DECIMAL(12,2) NOT NULL,
	INDEX(productProfileId),
	INDEX(productUnitId),
	FOREIGN KEY(productProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(productUnitId) REFERENCES unit(unitId),
	PRIMARY KEY(productId)
);



CREATE TABLE productCategory (
	productCategoryCategoryId INT UNSIGNED NOT NULL,
	productCategoryProductId INT UNSIGNED NOT NULL,
	INDEX (productCategoryCategoryId),
	INDEX (productCategoryProductId),
	FOREIGN KEY(productCategoryCategoryId) REFERENCES category(categoryId),
	FOREIGN KEY(productCategoryProductId) REFERENCES product(productId),
	PRIMARY KEY(productCategoryCategoryId, productCategoryProductId)
) ;

CREATE TABLE productImage(
	productImageImageId INT UNSIGNED NOT NULL,
	productImageProductId INT UNSIGNED NOT NULL,
	INDEX (productImageImageId),
	INDEX (productImageProductId),
	FOREIGN KEY(productImageImageId)REFERENCES image(imageId),
	FOREIGN KEY(productImageProductId)REFERENCES product(productId),
	PRIMARY KEY(productImageImageId, productImageProductId)
);

CREATE TABLE productPurchase(
	productPurchaseProductId INT UNSIGNED NOT NULL,
	productPurchasePurchaseId INT UNSIGNED NOT NULL,
	productPurchaseAmount DECIMAL(12,4) NOT NULL,
	INDEX (productPurchaseProductId),
	INDEX (productPurchasePurchaseId),
	FOREIGN KEY (productPurchaseProductId) REFERENCES product(productId),
	FOREIGN KEY (productPurchasePurchaseId) REFERENCES purchase(purchaseId),
	PRIMARY KEY (productPurchaseProductId, productPurchasePurchaseId)
);

CREATE TABLE profileImage (
	profileImageImageId INT UNSIGNED NOT NULL,
	profileImageProfileId INT UNSIGNED NOT NULL,
	INDEX (profileImageImageId),
	INDEX (profileImageProfileId),
	FOREIGN KEY (profileImageImageId) REFERENCES image(imageId),
	FOREIGN KEY (profileImageProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (profileImageImageId, profileImageProfileId)
);
