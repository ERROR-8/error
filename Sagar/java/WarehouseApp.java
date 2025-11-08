import java.util.*;

class Item {
    int id;
    String itemName;
    int quantity;

    Item(int id, String itemName, int quantity) {
        this.id = id;
        this.itemName = itemName;
        this.quantity = quantity;
    }
}

class Inventory {
    ArrayList<Item> items = new ArrayList<>();

    void addItem(int id, String name, int qty) {
        items.add(new Item(id, name, qty));
        System.out.println("Item added to inventory!");
    }

    void updateItem(int id, int change) {
        for (Item i : items) {
            if (i.id == id) {
                i.quantity += change;
                System.out.println("Stock updated successfully!");
                return;
            }
        }
        System.out.println("Item not found in inventory!");
    }

    void showItems() {
        System.out.println("\n--- Inventory Details ---");
        if (items.isEmpty()) {
            System.out.println("No items found!");
        } else {
            for (Item i : items) {
                System.out.println("ID: " + i.id + " | Name: " + i.itemName + " | Quantity: " + i.quantity);
            }
        }
    }
}

class Warehouse {
    Inventory inv = new Inventory();

    void addNewItem(int id, String name, int qty) {
        inv.addItem(id, name, qty);
    }

    void modifyStock(int id, int change) {
        inv.updateItem(id, change);
    }

    void displayReport() {
        inv.showItems();
    }
}

public class WarehouseApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Warehouse warehouse = new Warehouse();

        int choice;
        do {
            System.out.println("\n==== Warehouse Menu ====");
            System.out.println("1. Add Item");
            System.out.println("2. Update Stock");
            System.out.println("3. Show Inventory");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            choice = sc.nextInt();

            switch (choice) {
                case 1:
                    System.out.print("Enter item ID: ");
                    int id = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Enter item name: ");
                    String name = sc.nextLine();
                    System.out.print("Enter quantity: ");
                    int qty = sc.nextInt();
                    warehouse.addNewItem(id, name, qty);
                    break;

                case 2:
                    System.out.print("Enter item ID: ");
                    int id2 = sc.nextInt();
                    System.out.print("Enter quantity change (+/-): ");
                    int change = sc.nextInt();
                    warehouse.modifyStock(id2, change);
                    break;

                case 3:
                    warehouse.displayReport();
                    break;

                case 4:
                    System.out.println("Thank you! Exiting system...");
                    break;

                default:
                    System.out.println("Invalid input, try again!");
            }
        } while (choice != 4);

        sc.close();
