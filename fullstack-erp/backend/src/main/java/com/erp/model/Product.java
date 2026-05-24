package com.erp.model;
import jakarta.persistence.*;
import java.math.BigDecimal;

@Entity @Table(name="products")
public class Product {
    @Id @GeneratedValue(strategy=GenerationType.IDENTITY) private Long id;
    @Column(unique=true,nullable=false) private String sku;
    @Column(nullable=false) private String name;
    private String category; private String unit;
    private BigDecimal costPrice; private BigDecimal sellPrice;
    private Integer stockQty; private Integer safetyStock;
    private String branch;

    public Product() {}
    public Product(Long id,String sku,String name,String category,String unit,BigDecimal costPrice,BigDecimal sellPrice,Integer stockQty,Integer safetyStock,String branch){this.id=id;this.sku=sku;this.name=name;this.category=category;this.unit=unit;this.costPrice=costPrice;this.sellPrice=sellPrice;this.stockQty=stockQty;this.safetyStock=safetyStock;this.branch=branch;}
    public Long getId(){return id;} public void setId(Long id){this.id=id;}
    public String getSku(){return sku;} public void setSku(String sku){this.sku=sku;}
    public String getName(){return name;} public void setName(String name){this.name=name;}
    public String getCategory(){return category;} public void setCategory(String category){this.category=category;}
    public String getUnit(){return unit;} public void setUnit(String unit){this.unit=unit;}
    public BigDecimal getCostPrice(){return costPrice;} public void setCostPrice(BigDecimal costPrice){this.costPrice=costPrice;}
    public BigDecimal getSellPrice(){return sellPrice;} public void setSellPrice(BigDecimal sellPrice){this.sellPrice=sellPrice;}
    public Integer getStockQty(){return stockQty;} public void setStockQty(Integer stockQty){this.stockQty=stockQty;}
    public Integer getSafetyStock(){return safetyStock;} public void setSafetyStock(Integer safetyStock){this.safetyStock=safetyStock;}
    public String getBranch(){return branch;} public void setBranch(String branch){this.branch=branch;}
}
