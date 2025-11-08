import java.util.*;

class LowBal extends Exception {
    LowBal(String msg) {
        super(msg);
    }
}

class Acc {
    int num;
    double bal;

    Acc(int num, double bal) {
        this.num = num;
        this.bal = bal;
    }

    void dep(double amt) {
        bal += amt;
        System.out.println("Deposited: " + amt);
    }

    void with(double amt) throws LowBal {
        if (amt > bal)
            throw new LowBal("Insufficient balance!");
        bal -= amt;
        System.out.println("Withdrawn: " + amt);
    }

    void show() {
        System.out.println("Balance: " + bal);
    }
}

class Cust {
    String name;
    Acc ac;

    Cust(String name, Acc ac) {
        this.name = name;
        this.ac = ac;
    }
}

public class BankMain {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter name: ");
        String n = sc.nextLine();
        System.out.print("Enter account number: ");
        int a = sc.nextInt();

        Acc acc1 = new Acc(a, 1000);
        Cust c1 = new Cust(n, acc1);

        int ch;
        do {
            System.out.println("\n--- Bank Menu ---");
            System.out.println("1. Deposit");
            System.out.println("2. Withdraw");
            System.out.println("3. Check Balance");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    System.out.print("Enter amount: ");
                    double d = sc.nextDouble();
                    c1.ac.dep(d);
                    break;
                case 2:
                    System.out.print("Enter amount: ");
                    double w = sc.nextDouble();
                    try {
                        c1.ac.with(w);
                    } catch (LowBal e) {
                        System.out.println(e.getMessage());
                    }
                    break;
                case 3:
                    c1.ac.show();
                    break;
                case 4:
                    System.out.println("Thanks for using our bank!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
