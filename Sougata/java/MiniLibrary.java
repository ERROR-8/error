import java.util.*;

class Book {
    private final String bookName;
    private Member borrowedBy;

    Book(String bookName) {
        this.bookName = bookName;
        this.borrowedBy = null; // Initially not borrowed
    }

    public String getBookName() {
        return bookName;
    }

    public Member getBorrowedBy() {
        return borrowedBy;
    }

    public boolean isAvailable() {
        return borrowedBy == null;
    }

    void borrow(Member member) {
        this.borrowedBy = member;
    }

    void returnBook() {
        this.borrowedBy = null;
    }
}

class Member {
    private final String name;

    Member(String name) {
        this.name = name;
    }

    public String getName() {
        return name;
    }
}

class Library {
    private final List<Book> bookList = new ArrayList<>();

    void addBook(String name) {
        bookList.add(new Book(name));
    }

    void viewBooks() {
        System.out.println("\nAvailable Books:");
        boolean found = false;
        for (Book book : bookList) {
            if (book.isAvailable()) {
                System.out.println("- " + book.getBookName());
                found = true;
            }
        }
        if (!found) {
            System.out.println("No books are currently available.");
        }
    }

    void borrowBook(String bookName, Member member) {
        for (Book book : bookList) {
            if (book.getBookName().equalsIgnoreCase(bookName) && book.isAvailable()) {
                book.borrow(member);
                System.out.println(member.getName() + " borrowed \"" + book.getBookName() + "\" successfully.");
                return;
            }
        }
        System.out.println("Sorry, \"" + bookName + "\" is not available for borrowing.");
    }

    void returnBook(String bookName, Member member) {
        for (Book book : bookList) {
            if (book.getBookName().equalsIgnoreCase(bookName) && !book.isAvailable()) {
                if (book.getBorrowedBy() == member) {
                    book.returnBook();
                    System.out.println(member.getName() + " returned \"" + book.getBookName() + "\" successfully.");
                } else {
                    System.out.println("Error: This book was borrowed by " + book.getBorrowedBy().getName() + ", not you.");
                }
                return;
            }
        }
        System.out.println("Error: \"" + bookName + "\" was not found in the borrowed list.");
    }
}

public class MiniLibrary {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            Library library = new Library();
            library.addBook("Java Made Easy");
            library.addBook("C Programming");
            library.addBook("Computer Networks");

            System.out.print("Enter your name to become a library member: ");
            String userName = sc.nextLine();
            Member member = new Member(userName);
            System.out.println("Welcome, " + member.getName() + "!");

            int option;
            do {
                System.out.println("\n==== Library Menu ====");
                System.out.println("1. View Available Books");
                System.out.println("2. Borrow a Book");
                System.out.println("3. Return a Book");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                option = sc.nextInt();
                sc.nextLine(); // Consume the newline character

                switch (option) {
                    case 1:
                        library.viewBooks();
                        break;
                    case 2:
                        System.out.print("Enter book name to borrow: ");
                        String borrowName = sc.nextLine();
                        library.borrowBook(borrowName, member);
                        break;
                    case 3:
                        System.out.print("Enter book name to return: ");
                        String returnName = sc.nextLine();
                        library.returnBook(returnName, member);
                        break;
                    case 4:
                        System.out.println("Thank you for using the library!");
                        break;
                    default:
                        System.out.println("Invalid option! Please try again.");
                }
            } while (option != 4);
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a number for the menu choice.");
        }
    }
}
