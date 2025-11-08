import java.util.*;

class Product {
    int code;
    String name;
    int stock;

    Product(int code, String name, int stock) {
        this.code = code;
        this.name = name;
        this.stock = stock;
    }
}

class StockList {
    ArrayList<Product> products = new ArrayList<>();

    void addProduct(int code, String name, int qty) {
        products.add(new Product(code, name, qty));
        System.out.println("Product added successfully!");
    }

    void updateProduct(int code, int change) {
        for (Product p : products) {
            if (p.code == code) {
                p.stock += change;
                System.out.println("Stock updated!");
                return;
            }
        }
        System.out.println("Product not found!");
    }

    void showProducts() {
        System.out.println("\n--- Current Stock ---");
        if (products.isEmpty()) {
            System.out.println("No products available!");
        } else {
            for (Product p : products) {
                System.out.println("Code: " + p.code + " | Name: " + p.name + " | Stock: " + p.stock);
            }
        }
    }
}

class Store {
    StockList list = new StockList();

    void addNew(int code, String name, int qty) {
        list.addProduct(code, name, qty);
    }

    void changeStock(int code, int change) {
        list.updateProduct(code, change);
    }

    void report() {
        list.showProducts();
    }
}

public class StoreApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Store store = new Store();

        int ch;
        do {
            System.out.println("\n==== Store Menu ====");
            System.out.println("1. Add Product");
            System.out.println("2. Update Stock");
            System.out.println("3. Show Report");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    System.out.print("Enter product code: ");
                    int c = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Enter product name: ");
                    String n = sc.nextLine();
                    System.out.print("Enter stock quantity: ");
                    int q = sc.nextInt();
                    store.addNew(c, n, q);
                    break;

                case 2:
                    System.out.print("Enter product code: ");
                    int code = sc.nextInt();
                    System.out.print("Enter change in stock (+/-): ");
                    int change = sc.nextInt();
                    store.changeStock(code, change);
                    break;

                case 3:
                    store.report();
                    break;

                case 4:
                    System.out.println("System closed. Goodbye!");
                    break;

                default:
                    System.out.println("Invalid choice! Try again.");
            }
        } while (ch != 4);

        sc.close();
    }
}
