import java.util.*;
import java.math.BigDecimal;

class InsufficientFundsException extends Exception {
    InsufficientFundsException(String msg) {
        super(msg);
    }
}

class Account {
    private final int id;
    private BigDecimal balance;

    Account(int id, double initialBalance) {
        this.id = id;
        this.balance = BigDecimal.valueOf(initialBalance);
    }

    public int getId() {
        return id;
    }

    public BigDecimal getBalance() {
        return balance;
    }

    void deposit(BigDecimal amount) {
        if (amount.compareTo(BigDecimal.ZERO) <= 0) {
            System.out.println("Deposit amount must be positive.");
            return;
        }
        balance = balance.add(amount);
        System.out.println("Successfully deposited: " + amount);
    }

    void withdraw(BigDecimal amount) throws InsufficientFundsException {
        if (amount.compareTo(BigDecimal.ZERO) <= 0) {
            System.out.println("Withdrawal amount must be positive.");
            return;
        }
        if (amount.compareTo(balance) > 0) {
            throw new InsufficientFundsException("Insufficient funds for this withdrawal.");
        }
        balance = balance.subtract(amount);
        System.out.println("Successfully withdrew: " + amount);
    }
}

class Customer {
    private final String customerName;
    private final Account account;

    Customer(String customerName, Account account) {
        this.customerName = customerName;
        this.account = account;
    }

    public String getCustomerName() {
        return customerName;
    }

    public void deposit(BigDecimal amount) {
        account.deposit(amount);
    }

    public void withdraw(BigDecimal amount) {
        try {
            account.withdraw(amount);
        } catch (InsufficientFundsException e) {
            System.out.println("Error: " + e.getMessage());
            System.out.println("Your current balance is: " + account.getBalance());
        }
    }

    public void showBalance() {
        System.out.println("\n--- Account Details ---");
        System.out.println("Account Holder: " + customerName);
        System.out.println("Account Number: " + account.getId());
        System.out.println("Current Balance: $" + account.getBalance());
    }
}

public class BankDemo {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            System.out.print("Enter customer name: ");
            String name = sc.nextLine();
            System.out.print("Enter account number: ");
            int id = sc.nextInt();

            Account account = new Account(id, 1000.00); // Start with a default balance
            Customer customer = new Customer(name, account);

            int choice;
            do {
                System.out.println("\n==== Bank Menu ====");
                System.out.println("1. Deposit");
                System.out.println("2. Withdraw");
                System.out.println("3. Check Balance");
                System.out.println("4. Exit");
                System.out.print("Enter choice: ");
                choice = sc.nextInt();

                switch (choice) {
                    case 1:
                        System.out.print("Enter amount to deposit: ");
                        BigDecimal depositAmount = sc.nextBigDecimal();
                        customer.deposit(depositAmount);
                        break;
                    case 2:
                        System.out.print("Enter amount to withdraw: ");
                        BigDecimal withdrawAmount = sc.nextBigDecimal();
                        customer.withdraw(withdrawAmount);
                        break;
                    case 3:
                        customer.showBalance();
                        break;
                    case 4:
                        System.out.println("Thank you for banking with us, " + customer.getCustomerName() + "!");
                        break;
                    default:
                        System.out.println("Invalid option! Please try again.");
                }
            } while (choice != 4);
        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number. Exiting.");
        }
    }
}
