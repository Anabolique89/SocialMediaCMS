DROP DATABASE IF EXISTS ArtzoroDB3;
CREATE DATABASE ArtzoroDB3;
USE ArtzoroDB3;


CREATE TABLE  `Newsletter`(
    NewsletterID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Email varchar(255) NOT NULL
);

CREATE TABLE Walls(
    WallID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Name varchar(255) NULL,
    Status boolean NULL,
    ImageURL varchar(255) NULL,
    Address varchar(255) NOT NULL,
    About varchar(255) NULL,
    Created_At date NULL,
    Updated_At date NULL
);

CREATE TABLE User(
    UserID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Name varchar(255) NOT NULL, 
    Username varchar(255) NOT NULL,
    Pwd varchar(255) NOT NULL,
    UserProfile varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Role varchar(255) NOT NULL,
    Created_At date NULL,
    Updated_At date NULL
);


CREATE TABLE Artwork(
    id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    TitleArtwork varchar(255) NOT NULL,
    DescArtwork varchar(255) NOT NULL,
    ImgFullNameArtwork varchar(255) NOT NULL,
    OrderArtwork varchar(255) NOT NULL,
    Category varchar(255) NULL,
    Price varchar(255) NULL,
    Created_At date NULL,
    Updated_At date NULL,
    UserID int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User (UserID)
);


CREATE TABLE Profiles(
    ProfileID int AUTO_INCREMENT  NOT NULL PRIMARY KEY,
    FirstName varchar(255) NOT NULL,
    LastName varchar(255) NOT NULL,
    profilesAbout varchar(255) NOT NULL,
    DOB DATE NOT NULL,
    profileIntroTitle varchar(255) NOT NULL,
    profileIntroText varchar(512) NOT NULL,
    Created_At date NULL,
    Updated_At date NULL,
    UserID int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User (UserID)
);

CREATE TABLE Profileimg(
    id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Status varchar(255) NOT NULL,
    NewImgName varchar(255) NOT NULL,
    UserID int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User (UserID)
);

CREATE TABLE Comments(
    CommentID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Text varchar(255) NULL,
    Timestamp DATE NULL,
    UserID int NOT NULL,
    id int NOT NULL,
   FOREIGN KEY (UserID) REFERENCES User (UserID),
   FOREIGN KEY (id) REFERENCES Artwork (id)
);
CREATE TABLE Likes(
    LikeID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Text varchar(255) NULL,
    Timestamp DATE NULL,
    UserID int NOT NULL,
    id int NOT NULL,
   FOREIGN KEY (UserID) REFERENCES User (UserID),
   FOREIGN KEY (id) REFERENCES Artwork (id)
);

CREATE TABLE FollowerFollowing(
    FollowingID int NOT NULL,
    FollowerID int NOT NULL,
    UserID int NOT NULL,
    Timestamp DATE NULL,
    CONSTRAINT PK_FollowerFollowing PRIMARY KEY(UserID, FollowerID, FollowingID)

);

CREATE TABLE Notifications(
    NotificationID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Text varchar(512) NOT NULL,
    Status varchar(255) NOT NULL,
    Timestamp DATE NULL,
    UserID int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User (UserID)
);
