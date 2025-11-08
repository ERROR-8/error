import java.util.*;

class InsufficientFunds extends Exception {
    InsufficientFunds(String message) {
        super(message);
    }
}

class BankAccount {
    int accountNumber;
    double balance;

    BankAccount(int accountNumber, double balance) {
        this.accountNumber = accountNumber;
        this.balance = balance;
    }

    void deposit(double amount) {
        balance += amount;
        System.out.println("Deposit successful! Amount: " + amount);
    }

    void withdrawal(double amount) throws InsufficientFunds {
        if (amount > balance) {
            throw new InsufficientFunds("Insufficient balance for withdrawal!");
        }
        balance -= amount;
        System.out.println("Withdrawal successful! Amount: " + amount);
    }

    void checkBalance() {
        System.out.println("Current Balance: " + balance);
    }
}

class Customer {
    String customerName;
    BankAccount account;

    Customer(String customerName, BankAccount account) {
        this.customerName = customerName;
        this.account = account;
    }
}

public class BankSystemMain {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter customer name: ");
        String name = sc.nextLine();
        System.out.print("Enter account number: ");
        int accNo = sc.nextInt();

        BankAccount acc = new BankAccount(accNo, 1000); // default balance
        Customer cust = new Customer(name, acc);

        int choice;
        do {
            System.out.println("\n=== Simple Bank System ===");
            System.out.println("1. Deposit");
            System.out.println("2. Withdrawal");
            System.out.println("3. Check Balance");
            System.out.println("4. Exit");
            System.out.print("Enter your choice: ");
            choice = sc.nextInt();

            switch (choice) {
                case 1:
                    System.out.print("Enter amount to deposit: ");
                    double depAmount = sc.nextDouble();
                    cust.account.deposit(depAmount);
                    break;

                case 2:
                    System.out.print("Enter amount to withdraw: ");
                    double withAmount = sc.nextDouble();
                    try {
                        cust.account.withdrawal(withAmount);
                    } catch (InsufficientFunds e) {
                        System.out.println(e.getMessage());
                    }
                    break;

                case 3:
                    cust.account.checkBalance();
                    break;

                case 4:
                    System.out.println("Thank you, " + name + "! Visit again.");
                    break;

                default:
                    System.out.println("Invalid option! Please try again.");
            }
        } while (choice != 4);

        sc.close();
    }
}
