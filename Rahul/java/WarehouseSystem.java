import java.util.*;

class Product {
    int code;
    String name;
    int qty;

    Product(int code, String name, int qty) {
        this.code = code;
        this.name = name;
        this.qty = qty;
    }
}

class Stock {
    ArrayList<Product> list = new ArrayList<>();

    void addProduct(int code, String name, int qty) {
        list.add(new Product(code, name, qty));
        System.out.println("Product added successfully!");
    }

    void updateProduct(int code, int change) {
        for (Product p : list) {
            if (p.code == code) {
                p.qty += change;
                System.out.println("Stock updated successfully!");
                return;
            }
        }
        System.out.println("Product not found!");
    }

    void showStock() {
        System.out.println("\n--- Stock Report ---");
        if (list.isEmpty()) {
            System.out.println("No products available!");
        } else {
            for (Product p : list) {
                System.out.println("Code: " + p.code + " | Name: " + p.name + " | Quantity: " + p.qty);
            }
        }
    }
}

class Warehouse {
    Stock s = new Stock();

    void addNew(int code, String name, int qty) {
        s.addProduct(code, name, qty);
    }

    void modify(int code, int change) {
        s.updateProduct(code, change);
    }

    void report() {
        s.showStock();
    }
}

public class WarehouseSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Warehouse w = new Warehouse();

        int ch;
        do {
            System.out.println("\n==== Warehouse System ====");
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
                    System.out.print("Enter quantity: ");
                    int q = sc.nextInt();
                    w.addNew(c, n, q);
                    break;

                case 2:
                    System.out.print("Enter product code: ");
                    int code = sc.nextInt();
                    System.out.print("Enter quantity change (+/-): ");
                    int change = sc.nextInt();
                    w.modify(code, change);
                    break;

                case 3:
                    w.report();
                    break;

                case 4:
                    System.out.println("System closed. Goodbye!");
                    break;

                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
