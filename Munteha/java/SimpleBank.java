import java.util.*;

class LowBalance extends Exception {
    LowBalance(String msg) {
        super(msg);
    }
}

class BankAccount {
    int no;
    double bal;

    BankAccount(int no, double bal) {
        this.no = no;
        this.bal = bal;
    }

    void deposit(double amt) {
        bal += amt;
        System.out.println("Deposited: " + amt);
    }

    void withdraw(double amt) throws LowBalance {
        if (amt > bal) {
            throw new LowBalance("Not enough money in account!");
        }
        bal -= amt;
        System.out.println("Withdrawn: " + amt);
    }

    void show() {
        System.out.println("Current Balance: " + bal);
    }
}

class Person {
    String name;
    BankAccount acc;

    Person(String name, BankAccount acc) {
        this.name = name;
        this.acc = acc;
    }
}

public class SimpleBank {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter your name: ");
        String n = sc.nextLine();
        System.out.print("Enter account number: ");
        int num = sc.nextInt();

        BankAccount a1 = new BankAccount(num, 1000);
        Person p1 = new Person(n, a1);

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
                    p1.acc.deposit(d);
                    break;
                case 2:
                    System.out.print("Enter amount: ");
                    double w = sc.nextDouble();
                    try {
                        p1.acc.withdraw(w);
                    } catch (LowBalance e) {
                        System.out.println(e.getMessage());
                    }
                    break;
                case 3:
                    p1.acc.show();
                    break;
                case 4:
                    System.out.println("Thank you! Visit again.");
                    break;
                default:
                    System.out.println("Invalid option!");
            }
        } while (ch != 4);

        sc.close();
    }
}
