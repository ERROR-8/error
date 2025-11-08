import java.util.Scanner;
import java.util.ArrayList;

class Book { 
    public int sNo;
    public String bookName;
    public String authorName;
    public int bookQty;

    Scanner input = new Scanner(System.in);  

    public Book() {       
        System.out.println("Enter Serial No of Book:");
        this.sNo = input.nextInt();
        input.nextLine();

        System.out.println("Enter Book Name:");
        this.bookName = input.nextLine();

        System.out.println("Enter Author Name:");
        this.authorName = input.nextLine();        

        System.out.println("Enter Quantity of Books:");
        this.bookQty = input.nextInt();        
    }
}

class Member {
    public String name;
    public int slNo;
    public String bname;

    public Member(String name, int slNo, String bname) {
        this.name = name;
        this.slNo = slNo;
        this.bname = bname;
    }

    public void issueBook(Book book1) {
        if (book1.bookQty > 0 && bname.equalsIgnoreCase(book1.bookName)) {
            System.out.println("Successfully borrowed by " + name);
            book1.bookQty = book1.bookQty - 1;        
        }
    }

    public void returnBook(Book book1) {
        if (bname.equalsIgnoreCase(book1.bookName)) {
            System.out.println("Successfully returned by " + name);
            book1.bookQty = book1.bookQty + 1;        
        }
    }    
}

public class Library {
    public static void main(String args[]) {
        Book[] a = new Book[50];

        Book b1 = new Book();
        Book b2 = new Book();

        a[0] = b1;
        a[1] = b2;

        System.out.println(a[0].sNo + "   " + a[0].bookName + "   " + a[0].authorName + "      " + a[0].bookQty);
        System.out.println(a[1].sNo + "   " + a[1].bookName + "   " + a[1].authorName + "      " + a[1].bookQty);

        Member member1 = new Member("Rahul", 1, "python");
        member1.issueBook(b1);

        System.out.println("Updated/available book list after issuing:");
        System.out.println(a[0].sNo + "   " + a[0].bookName + "   " + a[0].authorName + "      " + a[0].bookQty);
        System.out.println(a[1].sNo + "   " + a[1].bookName + "   " + a[1].authorName + "      " + a[1].bookQty);

        Member member2 = new Member("Shyam", 2, "java");
        member2.issueBook(b2);

        System.out.println("Updated/available book list after issuing:");
        System.out.println(a[0].sNo + "   " + a[0].bookName + "   " + a[0].authorName + "      " + a[0].bookQty);
        System.out.println(a[1].sNo + "   " + a[1].bookName + "   " + a[1].authorName + "      " + a[1].bookQty);

        Member member3 = new Member("Rahul", 1, "python");
        Member member4 = new Member("Shyam", 2, "java");

        member3.returnBook(b1);
        member4.returnBook(b2);

        System.out.println("Updated/available book list after book return:");
        System.out.println(a[0].sNo + "   " + a[0].bookName + "   " + a[0].authorName + "      " + a[0].bookQty);
        System.out.println(a[1].sNo + "   " + a[1].bookName + "   " + a[1].authorName + "      " + a[1].bookQty);
    }
}