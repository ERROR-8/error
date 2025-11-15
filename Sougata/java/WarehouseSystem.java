import java.util.*;

class Product {
    private final int code;
    private final String name;
    private int quantity;

    public Product(int code, String name, int quantity) {
        this.code = code;
        this.name = name;
        this.quantity = quantity;
    }

    public int getCode() {
        return code;
    }

    public String getName() {
        return name;
    }

    public int getQuantity() {
        return quantity;
    }

    public void updateStock(int change) {
        if (this.quantity + change < 0) {
            System.out.println("Error: Not enough stock to remove. Current stock: " + this.quantity);
        } else {
            this.quantity += change;
            System.out.println("Stock for '" + this.name + "' updated successfully. New quantity: " + this.quantity);
        }
    }

    @Override
    public String toString() {
        return String.format("Code: %-5d | Name: %-20s | Quantity: %d", code, name, quantity);
    }
}

class Warehouse {
    private final Map<Integer, Product> stock = new TreeMap<>(); // TreeMap keeps products sorted by code

    public void addProduct(int code, String name, int quantity) {
        if (stock.containsKey(code)) {
            System.out.println("Error: A product with code " + code + " already exists.");
        } else if (quantity < 0) {
            System.out.println("Error: Cannot add a product with negative quantity.");
        } else {
            stock.put(code, new Product(code, name, quantity));
            System.out.println("Product '" + name + "' added successfully!");
        }
    }

    public void updateStock(int code, int quantityChange) {
        Product product = stock.get(code);
        if (product != null) {
            product.updateStock(quantityChange);
        } else {
            System.out.println("Error: Product with code " + code + " not found.");
        }
    }

    public void generateReport() {
        System.out.println("\n--- Stock Report ---");
        if (stock.isEmpty()) {
            System.out.println("The warehouse is empty.");
        } else {
            for (Product product : stock.values()) {
                System.out.println(product);
            }
        }
    }
}

public class WarehouseSystem {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            Warehouse warehouse = new Warehouse();

            int choice;
            do {
                System.out.println("\n==== Warehouse System ====");
                System.out.println("1. Add New Product");
                System.out.println("2. Update Product Stock");
                System.out.println("3. Generate Stock Report");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                choice = sc.nextInt();

                switch (choice) {
                    case 1:
                        System.out.print("Enter product code: ");
                        int code = sc.nextInt();
                        sc.nextLine(); // Consume newline
                        System.out.print("Enter product name: ");
                        String name = sc.nextLine();
                        System.out.print("Enter initial quantity: ");
                        int quantity = sc.nextInt();
                        warehouse.addProduct(code, name, quantity);
                        break;

                    case 2:
                        System.out.print("Enter product code to update: ");
                        int updateCode = sc.nextInt();
                        System.out.print("Enter quantity change (e.g., 50 to add, -10 to remove): ");
                        int change = sc.nextInt();
                        warehouse.updateStock(updateCode, change);
                        break;

                    case 3:
                        warehouse.generateReport();
                        break;

                    case 4:
                        System.out.println("System closed. Goodbye!");
                        break;

                    default:
                        System.out.println("Invalid choice! Please try again.");
                }
            } while (choice != 4);
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }
}
