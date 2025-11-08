import java.util.*;

class Product {
    int code;
    String itemName;
    int stock;

    Product(int code, String itemName, int stock) {
        this.code = code;
        this.itemName = itemName;
        this.stock = stock;
    }
}

class Store {
    ArrayList<Product> list = new ArrayList<>();

    void addProduct(int code, String name, int qty) {
        list.add(new Product(code, name, qty));
        System.out.println("Product added successfully!");
    }

    void updateStock(int code, int change) {
        for (Product p : list) {
            if (p.code == code) {
                p.stock += change;
                System.out.println("Stock updated successfully!");
                return;
            }
        }
        System.out.println("Product not found!");
    }

    void showAll() {
        System.out.println("\n--- Inventory Report ---");
        if (list.isEmpty()) {
            System.out.println("No products available.");
            return;
        }
        for (Product p : list) {
            System.out.println("Code: " + p.code + " | Name: " + p.itemName + " | Stock: " + p.stock);
        }
    }
}

class Warehouse {
    Store s = new Store();

    void addNewProduct(int code, String name, int qty) {
        s.addProduct(code, name, qty);
    }

    void changeProductStock(int code, int change) {
        s.updateStock(code, change);
    }

    void displayAll() {
        s.showAll();
    }
}

public class StockManager {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Warehouse w = new Warehouse();

        int choice;
        do {
            System.out.println("\n=== Warehouse Management ===");
            System.out.println("1. Add Product");
            System.out.println("2. Update Stock");
            System.out.println("3. Show Inventory");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            choice = sc.nextInt();

            switch (choice) {
                case 1:
                    System.out.print("Enter product code: ");
                    int c = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Enter product name: ");
                    String n = sc.nextLine();
                    System.out.print("Enter quantity: ");
                    int q = sc.nextInt();
                    w.addNewProduct(c, n, q);
                    break;

                case 2:
                    System.out.print("Enter product code: ");
                    int code = sc.nextInt();
                    System.out.print("Enter change in stock (+/-): ");
                    int ch = sc.nextInt();
                    w.changeProductStock(code, ch);
                    break;

                case 3:
                    w.displayAll();
                    break;

                case 4:
                    System.out.println("Thank you! Exiting system...");
                    break;

                default:
                    System.out.println("Invalid option!");
            }
        } while (choice != 4);

        sc.close();
    }
}
