CREATE TABLE "Assignations" (
	"UserID"	    	INTEGER NOT NULL UNIQUE,
	"City_Name" 		TEXT,
	"NetworkName"		TEXT,
	PRIMARY KEY("UserID" AUTOINCREMENT),
	FOREIGN KEY("City_Name") REFERENCES "City"("CityID"),
	FOREIGN KEY("NetworkName") REFERENCES "Network"("NetworkID"),
	FOREIGN KEY("UserID") REFERENCES "User_Details"("User_ID")
);

CREATE TABLE "City" (
	"CityID"	  	  	INTEGER NOT NULL UNIQUE,
	"City_Name"	  	  	TEXT NOT NULL UNIQUE,
	"Zipcode_From"		TEXT NOT NULL,
	"Zipcode_To"		TEXT NOT NULL,
	PRIMARY KEY("CityID" AUTOINCREMENT)
);

CREATE TABLE "LoginDetails" (
	"LoginID"		    INTEGER NOT NULL UNIQUE,
	"UserID"		    INTEGER NOT NULL UNIQUE,
	"Password"		    TEXT NOT NULL,
	PRIMARY KEY("LoginID" AUTOINCREMENT),
	FOREIGN KEY("UserID") REFERENCES "User_Details"("User_ID")
);

CREATE TABLE "Network" (
	"NetworkID"	   	 	INTEGER NOT NULL UNIQUE,
	"NetworkName"		TEXT NOT NULL UNIQUE,
	PRIMARY KEY("NetworkID" AUTOINCREMENT)
);

CREATE TABLE "Roles" (
	"Role_ID"			INTEGER NOT NULL UNIQUE,
	"Role"				INTEGER UNIQUE,
	PRIMARY KEY("Role_ID" AUTOINCREMENT)
);

CREATE TABLE "User_Details" (
	"User_ID"			INTEGER NOT NULL UNIQUE,
	"Fname"				TEXT NOT NULL,
	"SName"				TEXT NOT NULL,
	"RoleID"			INTEGER NOT NULL,
	"Email"				TEXT NOT NULL UNIQUE,
	"PhoneNo"			INTEGER UNIQUE,
	"HouseNo"			TEXT NOT NULL,
	"StreetName"		NUMERIC NOT NULL,
	"Zipcode"			TEXT NOT NULL,
	"Gender"			TEXT NOT NULL,
	"EmergencyContact"	INTEGER NOT NULL,
	PRIMARY KEY("User_ID" AUTOINCREMENT),
	FOREIGN KEY("RoleID") REFERENCES "Roles"("RoleID")
);


/*  INSERT FOR NETWORK TABLE */

INSERT INTO Network(NetworkID,NetworkName) VALUES
('01','Coteq'),
('02','Enduris'),
('03','Stedin'),
('04','Enexis'),
('05','Liander'),
('06','Westlandinfra'),
('07','Rendo');