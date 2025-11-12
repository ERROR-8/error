import java.util.*;

class BookItem {
    String bookName;
    boolean borrowed;
    BookItem(String bookName) {
        this.bookName = bookName;
        this.borrowed = false;
    }
}

class Reader {
    String name;
    Reader(String name) {
        this.name = name;
    }
}

class LibraryCenter {
    ArrayList<BookItem> bookList = new ArrayList<>();
    void addBook(String name) {
        bookList.add(new BookItem(name));
    }

    void viewBooks() {
        System.out.println("\nAvailable Books:");
        for (BookItem b : bookList) {
            if (!b.borrowed) {
                System.out.println("- " + b.bookName);
            }
        }
    }

    void getBook(String name, Reader r) {
        for (BookItem b : bookList) {
            if (b.bookName.equalsIgnoreCase(name) && !b.borrowed) {
                b.borrowed = true;
                System.out.println(r.name + " borrowed \"" + name + "\" successfully.");
                return;
            }
        }
        System.out.println("Sorry, book not available.");
    }

    void returnBook(String name, Reader r) {
        for (BookItem b : bookList) {
            if (b.bookName.equalsIgnoreCase(name) && b.borrowed) {
                b.borrowed = false;
                System.out.println(r.name + " returned \"" + name + "\" successfully.");
                return;
            }
        }
        System.out.println("This book was not borrowed.");
    }
}

public class MiniLibrary {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        LibraryCenter lib = new LibraryCenter();
        lib.addBook("Java Made Easy");
        lib.addBook("C Programming");
        lib.addBook("Computer Networks");
        System.out.print("Enter your name: ");
        String userName = sc.nextLine();
        Reader r = new Reader(userName);
        int option;
        do {
            System.out.println("\n==== Library Menu ====");
            System.out.println("1. View Books");
            System.out.println("2. Borrow Book");
            System.out.println("3. Return Book");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            option = sc.nextInt();
            sc.nextLine();
            switch (option) {
                case 1:
                    lib.viewBooks();
                    break;
                case 2:
                    System.out.print("Enter book name to borrow: ");
                    String bname = sc.nextLine();
                    lib.getBook(bname, r);
                    break;
                case 3:
                    System.out.print("Enter book name to return: ");
                    String rname = sc.nextLine();
                    lib.returnBook(rname, r);
                    break;
                case 4:
                    System.out.println("Thank you for using the library!");
                    break;
                default:
                    System.out.println("Invalid option!");
            }
        } while (option != 4);
        sc.close();
    }
}
