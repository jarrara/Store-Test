Technology Assessment- Exercise 1-PHP v.7 and MySQL v.4

The Retail Store Discounts -Problem Desc: on a retail website, the following discounts apply:

1.If the user is an employee of the store, he gets a 30% discount.

2.If the user is an affiliate of the store, he gets a 10% discount.
3.If the user has been a customer for over 2 years, he gets a 5% discount.
4.For every $100 on the bill, there would be a $5 discount (e.g. for $990, you get $45 as a discount).
5.The percentage based discounts do not apply on groceries.
6. A user can get only one of the percentage based discounts on a bill.

Solution:

1-Import DB file "db_project.sql" it will create 5 tables (cart, categories, product, users, user_oders).
2-Place all the content of "src" folder at your server .
3-Change config.php file which contains all credentials and settings such as db name, db user name, db password and grocery category id. 
4-UML Class Diagram attached "UML Class Diagram.jpg" 
5-Unit Testing is mentioned below and how to test 

//To begin the test, you have to declare below objects from Order class as shown below:
To test an employee user, use user number 1 and cart 1 
Test cases for user number 1,cart number 1 
$order_obj = new Order(1, 1);
$order_obj->get_order_summary();

//To test an affiliate user, use user number 2 and cart 2 
Test cases for user number 2,cart number 2 
$order_obj2 = new Order(2, 2); 
$order_obj2->get_order_summary();

//To test loyal user, use user number 3 and cart 3 
Test cases for user number 3,cart number 3 
$order_obj3 = new Order(3, 3); 
$order_obj3->get_order_summary();
