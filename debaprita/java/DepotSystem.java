import java.util.*;

class Item {
    private final int id;
    private final String name;
    private int quantity;

    public Item(int id, String name, int quantity) {
        this.id = id;
        this.name = name;
        this.quantity = quantity;
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public int getQuantity() {
        return quantity;
    }

    public boolean updateQuantity(int change) {
        if (this.quantity + change < 0) {
            return false; // Not enough stock
        }
        this.quantity += change;
        return true;
    }

    @Override
    public String toString() {
        return String.format("ID: %-5d | Name: %-20s | Quantity: %d", id, name, quantity);
    }
}

class Depot {
    private final Map<Integer, Item> stock = new TreeMap<>(); // TreeMap keeps items sorted by ID

    public boolean addItem(int id, String name, int quantity) {
        if (stock.containsKey(id)) {
            System.out.println("Error: An item with ID " + id + " already exists.");
            return false;
        }
        if (quantity < 0) {
            System.out.println("Error: Cannot add an item with negative quantity.");
            return false;
        }
        stock.put(id, new Item(id, name, quantity));
        return true;
    }

    public boolean updateItemQuantity(int id, int quantityChange) {
        Item item = stock.get(id);
        if (item == null) {
            System.out.println("Error: Item with ID " + id + " not found.");
            return false;
        }
        if (!item.updateQuantity(quantityChange)) {
            System.out.println("Error: Not enough stock to remove. Current stock: " + item.getQuantity());
            return false;
        }
        return true;
    }

    public void displayStock() {
        System.out.println("\n--- Stock Report ---");
        if (stock.isEmpty()) {
            System.out.println("No items available!");
        } else {
            stock.values().forEach(System.out::println);
        }
    }
}

public class DepotSystem {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            Depot depot = new Depot();

            int choice;
            do {
                System.out.println("\n==== Depot Menu ====");
                System.out.println("1. Add Item");
                System.out.println("2. Update Quantity");
                System.out.println("3. View Stock");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                choice = sc.nextInt();

                switch (choice) {
                    case 1:
                        System.out.print("Enter item ID: ");
                        int id = sc.nextInt();
                        sc.nextLine(); // Consume newline
                        System.out.print("Enter item name: ");
                        String name = sc.nextLine();
                        System.out.print("Enter quantity: ");
                        int qty = sc.nextInt();
                        if (depot.addItem(id, name, qty)) {
                            System.out.println("Item added successfully!");
                        }
                        break;

                    case 2:
                        System.out.print("Enter item ID: ");
                        int itemId = sc.nextInt();
                        System.out.print("Enter quantity change (+/-): ");
                        int change = sc.nextInt();
                        if (depot.updateItemQuantity(itemId, change)) {
                            System.out.println("Quantity updated successfully!");
                        }
                        break;

                    case 3:
                        depot.displayStock();
                        break;

                    case 4:
                        System.out.println("Exiting system... Goodbye!");
                        break;

                    default:
                        System.out.println("Invalid choice!");
                }
            } while (choice != 4);
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }
}
