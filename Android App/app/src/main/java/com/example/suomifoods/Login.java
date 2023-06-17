package com.example.suomifoods;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.textfield.TextInputEditText;
import com.vishnusivadas.advanced_httpurlconnection.PutData;

public class Login extends AppCompatActivity {

    TextInputEditText emailL, passwordL;
    Button buttonLogin;
    TextView textViewSignUp;
    String link;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        initialize();
        buttonClick();
    }

    private void initialize(){
        try {

            IpAddress ipA = new IpAddress();
            link = ipA.getAddress();

            emailL = findViewById(R.id.inpt_email);
            passwordL = findViewById(R.id.inpt_password);
            buttonLogin = findViewById(R.id.buttonLogin);
            textViewSignUp = findViewById(R.id.signup);
        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    private  void buttonClick(){

        buttonLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                login();
            }
        });

        textViewSignUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), SignUp.class);
                startActivity(intent);
            }
        });
    }

    private void login(){
        try {

            final String emailVal, passwordVal;
            emailVal = String.valueOf(emailL.getText());
            passwordVal = String.valueOf(passwordL.getText());

            if (validateEmail() && !passwordVal.equals("")) {

                Handler handler = new Handler();
                handler.post(new Runnable() {
                    @Override
                    public void run() {
                        //Starting Write and Read data with URL
                        //Creating array for parameters
                        String[] field = new String[2];
                        field[0] = "email";
                        field[1] = "password";

                        //Creating array for data
                        String[] data = new String[2];
                        data[0] = emailVal;
                        data[1] = passwordVal;

                        PutData putData = new PutData(link + "LoginRegister/login.php", "POST", field, data);
                        if (putData.startPut()) {
                            if (putData.onComplete()) {
                                String result = putData.getResult();
                                if (putData.getResult().toString().trim().equals("Login Success")) {

                                    Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT).show();
                                    Intent intent = new Intent(getApplicationContext(),Dashboard.class);
                                    intent.putExtra("email", emailVal);
                                    startActivity(intent);

                                } else {
                                    Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT).show();
                                }
                            }
                        }
                        //End Write and Read data with URL
                    }
                });
            } else {
                Toast.makeText(getApplicationContext(), "All Fields are Required", Toast.LENGTH_SHORT).show();
            }
        } catch(Exception ex){
            Log.e("EXCEPTION: " ,ex.toString());
        }
    }
    private Boolean validateEmail() {
        String val = emailL.getText().toString();
        String emailPattern = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";

        if (val.isEmpty()) {
            emailL.setError("Field cannot be empty");
            return false;
        } else if (!val.matches(emailPattern)) {
            emailL.setError("Invalid email address");
            return false;
        } else {
            emailL.setError(null);
            return true;
        }
    }
}