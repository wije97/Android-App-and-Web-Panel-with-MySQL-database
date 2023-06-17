package com.example.suomifoods;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Handler;
import android.util.Base64;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.vishnusivadas.advanced_httpurlconnection.PutData;

import java.util.ArrayList;

public class OrderAdapter extends BaseAdapter {

    private Context mContext;
    private String link;
    private String cus_id;

    private ArrayList<String> order_id = new ArrayList<String>();
    private ArrayList<String> order_price = new ArrayList<String>();
    private ArrayList<String> order_date = new ArrayList<String>();
    private ArrayList<String> order_status = new ArrayList<String>();


    public OrderAdapter(Context context, String cus_id, ArrayList<String> order_id, ArrayList<String> order_price, ArrayList<String> order_date, ArrayList<String> order_status, String link
    ) {
        this.mContext = context;
        this.cus_id=cus_id;
        this.order_id = order_id;
        this.order_price = order_price;
        this.order_date = order_date;
        this.order_status = order_status;
        this.link=link;
    }

    @Override
    public int getCount() {
        return order_id.size();
    }

    @Override
    public Object getItem(int position) {
        return null;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @SuppressLint("SetTextI18n")
    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        final OrderAdapter.viewHolder holder;
        LayoutInflater layoutInflater;
        if (convertView == null) {
            layoutInflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = layoutInflater.inflate(R.layout.order_list, null);
            holder = new OrderAdapter.viewHolder();
            holder.tv_o_id = (TextView) convertView.findViewById(R.id.tv_o_id);
            holder.tv_o_price = (TextView) convertView.findViewById(R.id.tv_o_t_price);
            holder.tv_o_date = (TextView) convertView.findViewById(R.id.tv_o_date);
            holder.tv_o_status = (TextView) convertView.findViewById(R.id.tv_0_status);
            convertView.setTag(holder);
        } else {
            holder = (OrderAdapter.viewHolder) convertView.getTag();
        }

        holder.tv_o_id.setText(order_id.get(position));
        holder.tv_o_price.setText(order_price.get(position));
        holder.tv_o_date.setText(order_date.get(position));
        holder.tv_o_status.setText(order_status.get(position));
        return convertView;
    }
    public class viewHolder {
        TextView tv_o_id;
        TextView tv_o_price;
        TextView tv_o_date;
        TextView tv_o_status;
    }

}
