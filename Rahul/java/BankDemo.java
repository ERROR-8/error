import java.util.*;

class LessMoney extends Exception {
    LessMoney(String msg) {
        super(msg);
    }
}

class Acct {
    int id;
    double bal;

    Acct(int id, double bal) {
        this.id = id;
        this.bal = bal;
    }

    void addMoney(double amt) {
        bal += amt;
        System.out.println("Money added: " + amt);
    }

    void takeMoney(double amt) throws LessMoney {
        if (amt > bal)
            throw new LessMoney("Not enough money!");
        bal -= amt;
        System.out.println("Money taken: " + amt);
    }

    void showBal() {
        System.out.println("Your balance: " + bal);
    }
}

class UserAcc {
    String cname;
    Acct acc;

    UserAcc(String cname, Acct acc) {
        this.cname = cname;
        this.acc = acc;
    }
}

public class BankDemo {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        System.out.print("Enter customer name: ");
        String name = sc.nextLine();
        System.out.print("Enter account number: ");
        int id = sc.nextInt();

        Acct a1 = new Acct(id, 1000);
        UserAcc u1 = new UserAcc(name, a1);

        int ch;
        do {
            System.out.println("\n==== Bank Menu ====");
            System.out.println("1. Deposit");
            System.out.println("2. Withdraw");
            System.out.println("3. Balance");
            System.out.println("4. Exit");
            System.out.print("Enter choice: ");
            ch = sc.nextInt();

            switch (ch) {
                case 1:
                    System.out.print("Enter amount: ");
                    double d = sc.nextDouble();
                    u1.acc.addMoney(d);
                    break;
                case 2:
                    System.out.print("Enter amount: ");
                    double w = sc.nextDouble();
                    try {
                        u1.acc.takeMoney(w);
                    } catch (LessMoney e) {
                        System.out.println(e.getMessage());
                    }
                    break;
                case 3:
                    u1.acc.showBal();
                    break;
                case 4:
                    System.out.println("Thank you, " + name + "!");
                    break;
                default:
                    System.out.println("Invalid option!");
            }
        } while (ch != 4);

        sc.close();
    }
}
