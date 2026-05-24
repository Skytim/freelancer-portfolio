package com.erp.model;
import jakarta.persistence.*;
import java.math.BigDecimal; import java.time.LocalDateTime;

@Entity @Table(name="purchase_orders")
public class PurchaseOrder {
    @Id @GeneratedValue(strategy=GenerationType.IDENTITY) private Long id;
    @Column(unique=true,nullable=false) private String orderNo;
    private String supplier; private String productName; private Integer quantity;
    private BigDecimal unitPrice; private BigDecimal totalAmount;
    private String branch; private String notes;
    @Enumerated(EnumType.STRING) private Status status;
    private LocalDateTime createdAt;

    public enum Status { PENDING, RECEIVED, CANCELLED }

    @PrePersist void onCreate(){ createdAt=LocalDateTime.now(); }

    public PurchaseOrder() {}
    public Long getId(){return id;} public void setId(Long id){this.id=id;}
    public String getOrderNo(){return orderNo;} public void setOrderNo(String orderNo){this.orderNo=orderNo;}
    public String getSupplier(){return supplier;} public void setSupplier(String supplier){this.supplier=supplier;}
    public String getProductName(){return productName;} public void setProductName(String productName){this.productName=productName;}
    public Integer getQuantity(){return quantity;} public void setQuantity(Integer quantity){this.quantity=quantity;}
    public BigDecimal getUnitPrice(){return unitPrice;} public void setUnitPrice(BigDecimal unitPrice){this.unitPrice=unitPrice;}
    public BigDecimal getTotalAmount(){return totalAmount;} public void setTotalAmount(BigDecimal totalAmount){this.totalAmount=totalAmount;}
    public String getBranch(){return branch;} public void setBranch(String branch){this.branch=branch;}
    public String getNotes(){return notes;} public void setNotes(String notes){this.notes=notes;}
    public Status getStatus(){return status;} public void setStatus(Status status){this.status=status;}
    public LocalDateTime getCreatedAt(){return createdAt;} public void setCreatedAt(LocalDateTime createdAt){this.createdAt=createdAt;}
}
