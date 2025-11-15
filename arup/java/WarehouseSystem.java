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

    public boolean updateStock(int change) {
        if (this.quantity + change < 0) {
            return false; // Indicate failure
        }
        this.quantity += change;
        return true; // Indicate success
    }

    @Override
    public String toString() {
        return String.format("Code: %-5d | Name: %-20s | Quantity: %d", code, name, quantity);
    }
}

enum AddProductStatus { SUCCESS, DUPLICATE_CODE, NEGATIVE_QUANTITY }
enum UpdateStockStatus { SUCCESS, NOT_FOUND, INSUFFICIENT_STOCK }

class Warehouse {
    private final Map<Integer, Product> stock = new TreeMap<>(); // TreeMap keeps products sorted by code

    public AddProductStatus addProduct(int code, String name, int quantity) {
        if (stock.containsKey(code)) {
            return AddProductStatus.DUPLICATE_CODE;
        }
        if (quantity < 0) {
            return AddProductStatus.NEGATIVE_QUANTITY;
        }
        stock.put(code, new Product(code, name, quantity));
        return AddProductStatus.SUCCESS;
    }

    public UpdateStockStatus updateStock(int code, int quantityChange) {
        Product product = stock.get(code);
        if (product == null) {
            return UpdateStockStatus.NOT_FOUND;
        }
        if (product.updateStock(quantityChange)) {
            return UpdateStockStatus.SUCCESS;
        }
        return UpdateStockStatus.INSUFFICIENT_STOCK;
    }

    public Collection<Product> getProducts() {
        return stock.values();
    }

    public Product findProduct(int code) {
        return stock.get(code);
    }
}

class WarehouseService {
    private final Warehouse warehouse;
    private final Scanner scanner;

    public WarehouseService(Warehouse warehouse, Scanner scanner) {
        this.warehouse = warehouse;
        this.scanner = scanner;
    }

    public void run() {
        int choice;
        do {
            printMenu();
            choice = scanner.nextInt();

            switch (choice) {
                case 1:
                    addNewProduct();
                    break;
                case 2:
                    updateProductStock();
                    break;
                case 3:
                    printStockReport();
                    break;
                case 4:
                    System.out.println("System closed. Goodbye!");
                    break;
                default:
                    System.out.println("Invalid choice! Please try again.");
            }
        } while (choice != 4);
    }

    private void printMenu() {
        System.out.println("\n==== Warehouse System ====");
        System.out.println("1. Add New Product");
        System.out.println("2. Update Product Stock");
        System.out.println("3. Generate Stock Report");
        System.out.println("4. Exit");
        System.out.print("Enter your choice: ");
    }

    private void addNewProduct() {
        System.out.print("Enter product code: ");
        int code = scanner.nextInt();
        scanner.nextLine(); // Consume newline
        System.out.print("Enter product name: ");
        String name = scanner.nextLine();
        System.out.print("Enter initial quantity: ");
        int quantity = scanner.nextInt();
        AddProductStatus status = warehouse.addProduct(code, name, quantity);

        switch (status) {
            case SUCCESS:
                System.out.println("Product '" + name + "' added successfully!");
                break;
            case DUPLICATE_CODE:
                System.out.println("Error: A product with code " + code + " already exists.");
                break;
            case NEGATIVE_QUANTITY:
                System.out.println("Error: Cannot add a product with negative quantity.");
                break;
        }
    }

    private void updateProductStock() {
        System.out.print("Enter product code to update: ");
        int updateCode = scanner.nextInt();
        System.out.print("Enter quantity change (e.g., 50 to add, -10 to remove): ");
        int change = scanner.nextInt();
        UpdateStockStatus status = warehouse.updateStock(updateCode, change);

        switch (status) {
            case SUCCESS:
                Product p = warehouse.findProduct(updateCode);
                System.out.println("Stock for '" + p.getName() + "' updated. New quantity: " + p.getQuantity());
                break;
            case NOT_FOUND:
                System.out.println("Error: Product with code " + updateCode + " not found.");
                break;
            case INSUFFICIENT_STOCK:
                System.out.println("Error: Not enough stock to remove.");
                break;
        }
    }

    private void printStockReport() {
        System.out.println("\n--- Stock Report ---");
        Collection<Product> products = warehouse.getProducts();
        if (products.isEmpty()) {
            System.out.println("The warehouse is empty.");
        } else {
            products.forEach(System.out::println);
        }
    }
}

public class WarehouseSystem {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            Warehouse warehouse = new Warehouse();
            WarehouseService service = new WarehouseService(warehouse, sc);
            service.run();
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }
}
