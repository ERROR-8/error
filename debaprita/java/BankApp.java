import java.util.*;
import java.math.BigDecimal;

class InsufficientFundsException extends Exception {
    public InsufficientFundsException(String message) {
        super(message);
    }
}

class BankAccount {
    private final int accountNumber;
    private final String accountHolder;
    private BigDecimal balance;

    public BankAccount(int accountNumber, String accountHolder, double initialBalance) {
        this.accountNumber = accountNumber;
        this.accountHolder = accountHolder;
        this.balance = BigDecimal.valueOf(initialBalance);
    }

    public int getAccountNumber() {
        return accountNumber;
    }

    public String getAccountHolder() {
        return accountHolder;
    }

    public BigDecimal getBalance() {
        return balance;
    }

    public void deposit(BigDecimal amount) {
        if (amount.compareTo(BigDecimal.ZERO) <= 0) {
            throw new IllegalArgumentException("Deposit amount must be positive.");
        }
        this.balance = this.balance.add(amount);
    }

    public void withdraw(BigDecimal amount) throws InsufficientFundsException {
        if (amount.compareTo(BigDecimal.ZERO) <= 0) {
            throw new IllegalArgumentException("Withdrawal amount must be positive.");
        }
        if (amount.compareTo(this.balance) > 0) {
            throw new InsufficientFundsException("Insufficient funds. Current balance: " + this.balance);
        }
        this.balance = this.balance.subtract(amount);
    }
}

public class BankApp {
    public static void main(String[] args) {
        try (Scanner sc = new Scanner(System.in)) {
            System.out.print("Enter Account Number: ");
            int num = sc.nextInt();
            sc.nextLine(); // Consume newline
            System.out.print("Enter Account Holder Name: ");
            String name = sc.nextLine();

            BankAccount acc = new BankAccount(num, name, 1000.00); // Default balance

            int choice;
            do {
                System.out.println("\n=== Bank Operations ===");
                System.out.println("1. Deposit");
                System.out.println("2. Withdraw");
                System.out.println("3. Check Balance");
                System.out.println("4. Exit");
                System.out.print("Enter your choice: ");
                choice = sc.nextInt();

                switch (choice) {
                    case 1:
                        try {
                            System.out.print("Enter deposit amount: ");
                            BigDecimal depositAmount = sc.nextBigDecimal();
                            acc.deposit(depositAmount);
                            System.out.println("Amount Deposited: " + depositAmount);
                        } catch (IllegalArgumentException e) {
                            System.out.println("Error: " + e.getMessage());
                        }
                        break;
                    case 2:
                        try {
                            System.out.print("Enter withdrawal amount: ");
                            BigDecimal withdrawAmount = sc.nextBigDecimal();
                            acc.withdraw(withdrawAmount);
                            System.out.println("Amount Withdrawn: " + withdrawAmount);
                        } catch (InsufficientFundsException | IllegalArgumentException e) {
                            System.out.println("Error: " + e.getMessage());
                        }
                        break;
                    case 3:
                        System.out.println("Account Holder: " + acc.getAccountHolder());
                        System.out.println("Current Balance: $" + acc.getBalance());
                        break;
                    case 4:
                        System.out.println("Thank you, " + acc.getAccountHolder() + "! Visit Again.");
                        break;
                    default:
                        System.out.println("Invalid option!");
                }
            } while (choice != 4);

        } catch (InputMismatchException e) {
            System.err.println("Invalid input. Please enter a valid number.");
        }
    }
}
