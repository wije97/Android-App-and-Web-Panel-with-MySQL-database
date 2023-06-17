package com.example.suomifoods;

public class IpAddress {

    String ip = "192.168.8.100";
    String root = "/WebProgramming/Hotel/api/";

    public String getAddress() {
        String link = "http://"+ ip + root;
        return link;
    }
}
