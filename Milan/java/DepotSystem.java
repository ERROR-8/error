import java.util.*;

class Goods {
    int itemId;
    String itemName;
    int itemQty;

    Goods(int itemId, String itemName, int itemQty) {
        this.itemId = itemId;
        this.itemName = itemName;
        this.itemQty = itemQty;
    }
}

class Stock {
    ArrayList<Goods> stockList = new ArrayList<>();

    void addGoods(int id, String name, int qty) {
        stockList.add(new Goods(id, name, qty));
        System.out.println("Goods added successfully!");
    }

    void updateGoods(int id, int qtyChange) {
        for (Goods g : stockList) {
            if (g.itemId == id) {
                g.itemQty += qtyChange;
                System.out.println("Quantity updated successfully!");
                return;
            }
        }
        System.out.println("Goods not found!");
    }

    void showAll() {
        System.out.println("\n--- Stock Report ---");
        if (stockList.isEmpty()) {
            System.out.println("No items available!");
        } else {
            for (Goods g : stockList) {
                System.out.println("ID: " + g.itemId + " | Name: " + g.itemName + " | Quantity: " + g.itemQty);
            }
        }
    }
}

class Depot {
    Stock st = new Stock();

    void addNewItem(int id, String name, int qty) {
        st.addGoods(id, name, qty);
    }

    void changeQty(int id, int qtyChange) {
        st.updateGoods(id, qtyChange);
    }

    void displayAll() {
        st.showAll();
    }
}

public class DepotSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Depot depot = new Depot();

        int ch;
        do {
            System.out.println("\n==== Depot Menu ====");
            System.out.println("1. Add Goods");
            System.out.println("2. Update Quantity");
            System.out.println("3. View Stock");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    System.out.print("Enter goods ID: ");
                    int id = sc.nextInt();
                    sc.nextLine();
                    System.out.print("Enter goods name: ");
                    String name = sc.nextLine();
                    System.out.print("Enter quantity: ");
                    int qty = sc.nextInt();
                    depot.addNewItem(id, name, qty);
                    break;

                case 2:
                    System.out.print("Enter goods ID: ");
                    int gid = sc.nextInt();
                    System.out.print("Enter quantity change (+/-): ");
                    int change = sc.nextInt();
                    depot.changeQty(gid, change);
                    break;

                case 3:
                    depot.displayAll();
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
