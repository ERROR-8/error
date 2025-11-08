import java.util.*;

class NoMoney extends Exception {
    NoMoney(String msg) {
        super(msg);
    }
}

class Account {
    int accNum;
    double bal;

    Account(int accNum, double bal) {
        this.accNum = accNum;
        this.bal = bal;
    }

    void add(double amt) {
        bal += amt;
        System.out.println("Added: " + amt);
    }

    void take(double amt) throws NoMoney {
        if (amt > bal) {
            throw new NoMoney("Not enough balance!");
        }
        bal -= amt;
        System.out.println("Taken: " + amt);
    }

    void check() {
        System.out.println("Balance: " + bal);
    }
}

class User {
    String name;
    Account acc;

    User(String name, Account acc) {
        this.name = name;
        this.acc = acc;
    }
}

public class BankApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter your name: ");
        String uname = sc.nextLine();
        System.out.print("Enter account number: ");
        int num = sc.nextInt();

        Account a = new Account(num, 1000);
        User u = new User(uname, a);

        int ch;
        do {
            System.out.println("\n==== Bank Menu ====");
            System.out.println("1. Deposit");
            System.out.println("2. Withdraw");
            System.out.println("3. Balance Check");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    System.out.print("Enter amount: ");
                    double d = sc.nextDouble();
                    u.acc.add(d);
                    break;
                case 2:
                    System.out.print("Enter amount: ");
                    double w = sc.nextDouble();
                    try {
                        u.acc.take(w);
                    } catch (NoMoney e) {
                        System.out.println(e.getMessage());
                    }
                    break;
                case 3:
                    u.acc.check();
                    break;
                case 4:
                    System.out.println("Goodbye " + uname + "!");
                    break;
                default:
                    System.out.println("Wrong choice!");
            }
        } while (ch != 4);

        sc.close();
    }
}
