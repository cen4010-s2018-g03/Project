<!DOCTYPE HTML>
<html>
<body>
<!-- I'll go back and fix the formatting here later -Josh -->
1. Executive Summary
	From Room 205 of Florida Atlantic University’s (FAU) Engineering East building, Perry Weinthal sells or leases various electronic parts and equipment, as well as manufactured pieces (such as those from a 3D printer) by request. To facilitate inventory-tracking, we are producing the Florida Atlantic University Original Web eLectronics Store (FAUOWLS), where students will be able to search for and purchase items they seek, and Perry and his team will be able to keep track of all equipment and parts as they come in and go out. Many web stores, such as Newark element14 (http://www.newark.com) already exist that sell electronic equipment, and Perry often purchases equipment and parts from such sites, in addition to purchasing from more general-purpose web stores like eBay (https://www.ebay.com).
	The uniqueness of the FAUOWLS is that it would primarily target students at FAU either currently taking or who have taken courses in computer science, computer engineering, or electrical engineering, who would be able to purchase at no cost many electronic parts that would otherwise cost some non-zero amount, as well as lease or rent more complex equipment for free - equipment that would otherwise be prohibitively expensive for the average university student. FAUOWLS will also allow those on Perry’s team to locate equipment in various laboratories upon request, saving them the trouble of either having to memorize the location of every part or spend excessive time rummaging through drawers to find what a student seeks. Faculty, additionally, will be able to purchase, rent, or lease equipment or parts, at little to no cost, while FAUOWLS will allow Perry’s team to track all such prices in one central database.
	Ultimately, FAUOWLS would allow Perry and his team to be more productive, and allow students and faculty needing parts and equipment to have a clear, easily accessible system for finding and obtaining what they’re looking for to excel in their courses - or even engineer their own experiments.
	
2. Competitive Analysis 
Competitors
Ours
Multiple Ways to Pay
No Money Exchange Needed
Algorithms for Personal Recommendations
Focus on Optimizing Search/Sort Algorithms
Focus on Advertising
Clean Presentation Focusing on Functionality
 
	The competitive relationship to web stores that are currently available is somewhat parallel, due to the contrast in goals and our exclusive audience (FAU Students and Faculty). The typical focus of a web store is to advertise and sell, which is apparent on bigger companies’ sites, such as Amazon. However, when users are accessing our site, they will be in search of parts or services required for a class, project, or something school-related. Inherently, this removes our need to follow in the footsteps of competitive sites, which focus on advertising, and allow us to focus on the functionality of the store. We will prioritize a clean user interface and fast search/sort algorithms. We will follow suit with organizational conventions of typical web stores, such as categorized inventory and navigation menus. This will allow users to find what they need swiftly, along with keeping different pages of the store clutter-free. Ultimately, the store will compete with search and load times of bigger competitors, along with the ease of utility that is found among the best sites.

3. Data definition

Admin – Administrator’s account. Will be able to create/edit Staff and Client accounts, approve item requests from Clients and order items from Vendors to send to Inventory.
	Admin attributes:
		Username - Username with which Admin logs in.
		Password - A single password/key used by the Admin to log in to his/her account.

Client – Person (FAU student, faculty et al.) ordering or renting item(s) from Inventory. May also request items from Admin.
	Client attributes:
		Znumber - Primary key. Client’s FAU-assigned Z-number.
		Password – Password/key for client to log in to his/her account. Created by user.
		Major - Client’s major at FAU. User-selected.
		Courses – Client’s current courses at FAU.
		Graduation date – Client’s expected graduation date.
		Cart – Stores part number for each item added for prospective purchase/rental by Client. Where final purchase or rent function can be applied.
		Purchase and Rent History – A list of all previous purchases and rentals. Includes Part Number, Order or Rent Date, Pick-up Date, and Return Date if part was or is being rented.
		Client’s Orders – Current client pending orders.

Engineering Lab Staff – Account that shall be able to view Client orders, view Client account history, create Kits, add items to Inventory, and add new Vendors.
Engineering Lab Staff attributes:
Username - Each engineering staff member will use a unique log-in created by the Admin.
Password - A single password/key for Engineering Lab Staff to log in to his/her account.
 
Inventory – Stores product inventory available for clients to purchase/rent.
Inventory attributes:
Part number - Primary key for Inventory item.
Short Description – A short text description of the product in minimal detail.
Long Description – A detailed text description of the product.
Image – Capable of storing multiple images in specified format.
Data Sheet - Data in an Excel spreadsheet or PDF that can be uploaded.
Location in Lab – Specifies where Inventory item located in lab.
Quantity – Quantity of Inventory item available in lab for purchase/rent.
Purchase or Rent – Indicates whether Inventory item available for purchase, rent, or both. 
Barcode - Bar code associated with product.
Purchase Price – Original price per item paid to Vendor for purchase by lab.
Ordinary Selling Price - Price per item when sold to Client.
Bulk Selling Price – Price per Bulk Quantity at which item is sold to Client.
Bulk Quantity - Quantity of Inventory item for which Bulk Selling Price applies.
Jobber Selling Price - Price per item when sold to a middle man.
Vendor part number – The vendor’s part number.
Part availability per client – A limit set on each part that a client can order depending on the group certification.
 
Vendor – Company from which some item in Inventory is ordered or can be ordered.
 Vendor attributes:
Name – Name of vendor company.
Address - Physical address of the vendor.
Account number - Each vendor will have a unique account number used as a primary key.
Order History – List of all items with Quantity and Purchase Date ordered by Admin.

4
Overview:
        	The FAUOWLS will be used by both Engineering Lab Staff and FAU students and faculty as a way to distribute goods for engineering projects, as well as services, generating a record of transactions. Students will be able to identify through their FAU ID, log into their account and "purchase"/"rent" any needed parts or "hire" troubleshooting and printing services. For these services, students will need to upload different types of files. Staff will be able to keep track of real-time inventory and their location; when orders are generated, these should indicate the physical location of the products. Products and suppliers can be created and modified by the Staff. Products will have an image associated to it, as well as data sheets, which can be uploaded by clients with a pending approval from the Staff, and different prices depending on the customer classification. There will be assembled products, which will be conformed of other products, affecting the inventory. They system will offer an option to add the assembled kits to stock, where it will calculate if the necessary amount of input products is in stock, if there is no sufficient stock the system will inform what is missing.
 
Scenario:
        	Jack is a Computer Engineering student taking Logic Design, therefore skilled on computer tasks. At the beginning of the semester Jack is given a kit including two breadboards, LEDs, resistors and various other parts. Unfortunately, Jack makes a mistake and causes some LEDs to stop working. On the next class, he talks to his classmates about this problem, since he needs a white LED to finish his Lab project; they suggest that he uses FAUOWLS to order the part he needs. Jack signs in to FAUOWLS using his FAU ID and Z-number, browses for the white LED he needs and orders it at no cost. Later, he goes to room 205 on Engineering East building, where Perry or another member of Perry’s team scans Client’s OWL Card, pulls up his order, which indicates where in the Engineering Lab the white LED is located, and delivers it to Jack.
 
Initial Assumption: The user has successfully signed up to the FAUOWLS and the item needed is in stock.
 
Normal: When signing up, the user must enter his personal information and Z number. When browsing for the desired item there is a search function to find the item, which has a description, photo and data sheet to avoid confusion.
 
What can go wrong: User may order the wrong item since parts often look alike and user may not pay attention to data sheets.
 
System state on completion: After ordering, the stock of the item is reduced by the amount ordered. There is a record of the transaction on the system.

Use Cases:

 

5  High-level Functional Requirements
1.       Account system shall allow for students or staff to make purchases using Z-number. (no real money exchanged).
a.       Rental/leases shall have a strict time limit.
b.       Admin shall be able to track what is taken and how much to keep track and order when supplies are low.
2.       Admin shall be able to apply separate price for Jobbers, those purchasing as a middle man, such as another FAU department.
3.      Admin shall be able to apply separate Bulk price for when client requests a large amount of an item.
4.       Store shall produce a live-updating spreadsheet on the website which shows past rental/lease dates, inventory etc.
5.       Store map shall show whoever is working exactly where an item is in EE205.
6.       Client shall be able to upload a file for 3d Printing, circuit board milling or laser cutting. (.jpg, .tiff, etc.)
7.     There shall be a list of vendors and their websites for easy access.
8.       Pictures for each specific item will be able to be uploaded to the webstore.
9.       Any special orders will send an email notification to those who ordered the item that it is ready.
10.   There shall be a standard module implementation for barcodes.
11.   Students should be able to upload data sheets that can be used at the staff’s discretion.
12.   Account should keep track of client’s purchase/rental history.
13.  Staff and Admin shall have privileges that Client won’t. 
14.  Admin shall manage accounts with permissions unavailable to Lab Staff or Client.
15.  System shall subtract item quantity from Inventory after purchase or rental, and shall add to Inventory when rented item is returned.
16.   Any item request shall be submitted to FAUOWLS as a ticket. Engineering Lab Staff shall see the request immediately upon submission for order to be fulfilled.

6 
Non Functional Requirements:  
1. To sign in to FAUOWLS, user shall connect to FAU Single Sign-on with corresponding credentials.
2. If a student orders an item for a specific course, the system shall not need to check if student is currently registered for the course.
3. Expected load is no more than 300 simultaneous users.

7
	The Florida Atlantic University Original eLectronics Web Store (FAUOWLS) would require for its production use of computer languages HTML, CSS, JavaScript, PHP, and SQL. It will support all popular Internet browsers, with a focus on mobile (Apple Safari for iOS, Google Chrome for Mobile). The front-end framework will be from Bootstrap (https://getbootstrap.com/), back-end from Loopback (https://loopback.io). 


8
Group 03:
Brett Marks: Front-end Team Lead, Developer
Joshua Cordes: Product Owner, Developer
Alvaro Feola: Github Master, Developer
William Young: Back-end Team Lead, Developer
Martin Sanchez: Scrum Master, Developer


9
a)     Team decided on basic means of communications: DONE
b)    Team found a time slot to meet outside of the class: DONE
c)     Front and back end team leads chosen: DONE
d)    Github master chosen: DONE
e)     Team ready and able to use the chosen back and front-end frameworks: ON TRACK
f)      Skills of each team member defined and known to all: ON TRACK
g)     Team lead ensured that all team members read the final M1 and agree/understand it before submission: ON TRACK
</body>
</html>
