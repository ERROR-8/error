import java.util.*;

class Item {
    int id;
    String name;
    int quantity;

    Item(int id, String name, int quantity) {
        this.id = id;
        this.name = name;
        this.quantity = quantity;
    }
}

class Inventory {
    ArrayList<Item> items = new ArrayList<>();

    void addItem(int id, String name, int qty) {
        items.add(new Item(id, name, qty));
        System.out.println("Item added successfully!");
    }

    void updateItem(int id, int qtyChange) {
        for (Item i : items) {
            if (i.id == id) {
                i.quantity += qtyChange;
                System.out.println("Stock updated successfully!");
                return;
            }
        }
        System.out.println("Item not found!");
    }

    void showReport() {
        System.out.println("\n--- Inventory Report ---");
        for (Item i : items) {
            System.out.println("ID: " + i.id + " | Name: " + i.name + " | Quantity: " + i.quantity);
        }
    }
}

class Warehouse {
    Inventory inv = new Inventory();

    void addNewItem(int id, String name, int qty) {
        inv.addItem(id, name, qty);
    }

    void changeStock(int id, int qtyChange) {
        inv.updateItem(id, qtyChange);
    }

    void displayReport() {
        inv.showReport();
    }
}

public class WarehouseSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Warehouse w = new Warehouse();

        int ch;
        do {
            System.out.println("\n=== Warehouse Menu ===");
            System.out.println("1. Add New Item");
            System.out.println("2. Update Stock");
            System.out.println("3. Show Inventory");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    System.out.print("Enter item ID: ");
                    int id = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Enter item name: ");
                    String name = sc.nextLine();
                    System.out.print("Enter quantity: ");
                    int qty = sc.nextInt();
                    w.addNewItem(id, name, qty);
                    break;

                case 2:
                    System.out.print("Enter item ID: ");
                    int id2 = sc.nextInt();
                    System.out.print("Enter quantity to add/remove (e.g., 10 or -5): ");
                    int qChange = sc.nextInt();
                    w.changeStock(id2, qChange);
                    break;

                case 3:
                    w.displayReport();
                    break;

                case 4:
                    System.out.println("Exiting system... Goodbye!");
                    break;

                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
