import java.util.*;

class Book {
    String name;
    boolean issued;

    Book(String name) {
        this.name = name;
        this.issued = false;
    }
}

class Member {
    String name;

    Member(String name) {
        this.name = name;
    }
}

class Library {
    ArrayList<Book> bookList = new ArrayList<>();

    void addBook(String name) {
        bookList.add(new Book(name));
    }

    void showBooks() {
        System.out.println("\nAvailable Books:");
        for (Book b : bookList) {
            if (!b.issued) {
                System.out.println("- " + b.name);
            }
        }
    }

    void issueBook(String name, Member m) {
        for (Book b : bookList) {
            if (b.name.equalsIgnoreCase(name) && !b.issued) {
                b.issued = true;
                System.out.println(m.name + " issued \"" + name + "\"");
                return;
            }
        }
        System.out.println("Book not available.");
    }

    void returnBook(String name, Member m) {
        for (Book b : bookList) {
            if (b.name.equalsIgnoreCase(name) && b.issued) {
                b.issued = false;
                System.out.println(m.name + " returned \"" + name + "\"");
                return;
            }
        }
        System.out.println("Book not found or not issued.");
    }
}

public class SimpleLibrary {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Library lib = new Library();

        // Add some books
        lib.addBook("Java");
        lib.addBook("Python");
        lib.addBook("C++");

        System.out.print("Enter your name: ");
        String userName = sc.nextLine();
        Member m = new Member(userName);

        int choice;
        do {
            System.out.println("\n--- Library Menu ---");
            System.out.println("1. Show books");
            System.out.println("2. Issue book");
            System.out.println("3. Return book");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            choice = sc.nextInt();
            sc.nextLine(); // clear buffer

            switch (choice) {
                case 1:
                    lib.showBooks();
                    break;
                case 2:
                    System.out.print("Enter book name to issue: ");
                    String issueName = sc.nextLine();
                    lib.issueBook(issueName, m);
                    break;
                case 3:
                    System.out.print("Enter book name to return: ");
                    String returnName = sc.nextLine();
                    lib.returnBook(returnName, m);
                    break;
                case 4:
                    System.out.println("Goodbye!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (choice != 4);
        sc.close();
    }
}
