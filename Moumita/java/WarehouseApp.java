import java.util.*;

class Item {
    int id;
    String name;
    int stock;

    Item(int id, String name, int stock) {
        this.id = id;
        this.name = name;
        this.stock = stock;
    }
}

class Store {
    ArrayList<Item> items = new ArrayList<>();

    void addItem(int id, String name, int qty) {
        items.add(new Item(id, name, qty));
        System.out.println("Item added successfully!");
    }

    void changeStock(int id, int qtyChange) {
        for (Item i : items) {
            if (i.id == id) {
                i.stock += qtyChange;
                System.out.println("Stock updated!");
                return;
            }
        }
        System.out.println("Item not found!");
    }

    void showAll() {
        System.out.println("\n--- Inventory List ---");
        if (items.isEmpty()) {
            System.out.println("No items in stock!");
        } else {
            for (Item i : items) {
                System.out.println("ID: " + i.id + " | Name: " + i.name + " | Stock: " + i.stock);
            }
        }
    }
}

class Warehouse {
    Store s = new Store();

    void addNew(int id, String name, int qty) {
        s.addItem(id, name, qty);
    }

    void update(int id, int qtyChange) {
        s.changeStock(id, qtyChange);
    }

    void report() {
        s.showAll();
    }
}

public class WarehouseApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Warehouse w = new Warehouse();

        int ch;
        do {
            System.out.println("\n==== Warehouse Menu ====");
            System.out.println("1. Add Item");
            System.out.println("2. Update Stock");
            System.out.println("3. Show Report");
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
                    w.addNew(id, name, qty);
                    break;

                case 2:
                    System.out.print("Enter item ID: ");
                    int id2 = sc.nextInt();
                    System.out.print("Enter quantity change (+/-): ");
                    int change = sc.nextInt();
                    w.update(id2, change);
                    break;

                case 3:
                    w.report();
                    break;

                case 4:
                    System.out.println("Exiting system... Goodbye!");
                    break;

                default:
                    System.out.println("Invalid input! Try again.");
            }
        } while (ch != 4);

        sc.close();
    }
}
