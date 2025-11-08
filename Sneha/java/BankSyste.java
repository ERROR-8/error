import java.util.*;

class Account {
    int accNo;
    String name;
    double balance;

    Account(int accNo, String name, double balance) {
        this.accNo = accNo;
        this.name = name;
        this.balance = balance;
    }

    void deposit(double amount) {
        balance += amount;
        System.out.println("Deposited: " + amount);
    }

    void withdraw(double amount) {
        if (amount > balance) {
            System.out.println("Insufficient balance!");
        } else {
            balance -= amount;
            System.out.println("Withdrawn: " + amount);
        }
    }

    void checkBalance() {
        System.out.println("Current Balance: " + balance);
    }
}

public class BankSystem {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter Account Number: ");
        int accNo = sc.nextInt();
        sc.nextLine(); // clear buffer
        System.out.print("Enter Account Holder Name: ");
        String name = sc.nextLine();

        Account acc = new Account(accNo, name, 1000); // Initial balance

        int choice;
        do {
            System.out.println("\n=== Bank Menu ===");
            System.out.println("1. Deposit");
            System.out.println("2. Withdraw");
            System.out.println("3. Check Balance");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            choice = sc.nextInt();

            switch (choice) {
                case 1:
                    System.out.print("Enter amount to deposit: ");
                    double d = sc.nextDouble();
                    acc.deposit(d);
                    break;
                case 2:
                    System.out.print("Enter amount to withdraw: ");
                    double w = sc.nextDouble();
                    acc.withdraw(w);
                    break;
                case 3:
                    acc.checkBalance();
                    break;
                case 4:
                    System.out.println("Thank you for banking with us!");
                    break;
                default:
                    System.out.println("Invalid choice!");
            }
        } while (choice != 4);

        sc.close();
    }
}
