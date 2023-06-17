package com.example.suomifoods;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.textfield.TextInputEditText;
import com.vishnusivadas.advanced_httpurlconnection.PutData;

public class SignUp extends AppCompatActivity {

    TextInputEditText nic, fullName, password, email, phoneNo, address, age;
    Button signUp;
    TextView loginText;
    ProgressBar progressBar;
    String link;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);

        initialize();
        buttonClick();
    }

    private void initialize(){
        try {

            IpAddress ipA = new IpAddress();
            link = ipA.getAddress();

            nic = findViewById(R.id.et_nic);
            fullName = findViewById(R.id.et_fullname);
            password = findViewById(R.id.et_password);
            email = findViewById(R.id.et_email);
            phoneNo = findViewById(R.id.et_phone_no);
            address = findViewById(R.id.et_address);
            age = findViewById(R.id.et_age);
            signUp = findViewById(R.id.buttonSignUp);
            loginText = findViewById(R.id.loginText);
            progressBar = findViewById(R.id.pb_progress);

        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    private  void buttonClick(){
        signUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                insertData();
            }
        });

        loginText.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), Login.class);
                startActivity(intent);
            }
        });
    }

    private void insertData(){
        try {
            final String nicVal, nameVal, passwordVal, emailVal, pNoVal, addressVal, ageVal;
            nicVal = String.valueOf(nic.getText());
            nameVal = String.valueOf(fullName.getText());
            passwordVal = String.valueOf(password.getText());
            emailVal = String.valueOf(email.getText());
            pNoVal = String.valueOf(phoneNo.getText());
            addressVal = String.valueOf(address.getText());
            ageVal = String.valueOf(age.getText());

            if(!nicVal.equals("") && !nameVal.equals("") && !passwordVal.equals("") && validateEmail() && !pNoVal.equals("") && !addressVal.equals("") && !ageVal.equals("")) {

                progressBar.setVisibility(View.VISIBLE);
                Handler handler = new Handler();
                handler.post(new Runnable() {
                    @Override
                    public void run() {
                        //Starting Write and Read data with URL
                        //Creating array for parameters
                        String[] field = new String[7];
                        field[0] = "full_name";
                        field[1] = "nic";
                        field[2] = "age";
                        field[3] = "address";
                        field[4] = "phone_no";
                        field[5] = "email";
                        field[6] = "password";
                        //Creating array for data
                        String[] data = new String[7];
                        data[0] = nameVal;
                        data[1] = nicVal;
                        data[2] = ageVal;
                        data[3] = addressVal;
                        data[4] = pNoVal;
                        data[5] = emailVal;
                        data[6] = passwordVal;

                        PutData putData = new PutData(link + "LoginRegister/signup.php", "POST", field, data);
                        if (putData.startPut()) {
                            if (putData.onComplete()) {
                                progressBar.setVisibility(View.GONE);
                                String result = putData.getResult();
                                if(putData.getResult().toString().trim().equals("Sign Up Success.Please Login Back")){
                                    Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT). show();
                                    Intent intent = new Intent(getApplicationContext(),Login.class);
                                    startActivity(intent);
                                }

                                else{
                                    Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT). show();
                                }

                            }
                        }

                    }
                });
            }

            else {
                Toast.makeText(getApplicationContext(),"All Fields are Required", Toast.LENGTH_SHORT).show();
            }
        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }
    private Boolean validateEmail() {
        String val = email.getText().toString();
        String emailPattern = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";

        if (val.isEmpty()) {
            email.setError("Field cannot be empty");
            return false;
        } else if (!val.matches(emailPattern)) {
            email.setError("Invalid email address");
            return false;
        } else {
            email.setError(null);
            return true;
        }
    }
}