import java.util.*;

class BankAccount {
    int number;
    String holder;
    double balance;

    BankAccount(int number, String holder, double balance) {
        this.number = number;
        this.holder = holder;
        this.balance = balance;
    }

    void depositMoney(double amt) {
        balance += amt;
        System.out.println("Amount Deposited: " + amt);
    }

    void withdrawMoney(double amt) {
        if (amt > balance) {
            System.out.println("Insufficient Balance!");
        } else {
            balance -= amt;
            System.out.println("Amount Withdrawn: " + amt);
        }
    }

    void showBalance() {
        System.out.println("Account Balance: " + balance);
    }
}

public class BankApp {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter Account Number: ");
        int num = sc.nextInt();
        sc.nextLine();
        System.out.print("Enter Account Holder Name: ");
        String name = sc.nextLine();

        BankAccount acc = new BankAccount(num, name, 1000); // Default balance

        int ch;
        do {
            System.out.println("\n=== Bank Operations ===");
            System.out.println("1. Deposit");
            System.out.println("2. Withdraw");
            System.out.println("3. Check Balance");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    System.out.print("Enter deposit amount: ");
                    double d = sc.nextDouble();
                    acc.depositMoney(d);
                    break;
                case 2:
                    System.out.print("Enter withdrawal amount: ");
                    double w = sc.nextDouble();
                    acc.withdrawMoney(w);
                    break;
                case 3:
                    acc.showBalance();
                    break;
                case 4:
                    System.out.println("Thank you, " + name + "! Visit Again.");
                    break;
                default:
                    System.out.println("Invalid option!");
            }
        } while (ch != 4);

        sc.close();
    }
}
