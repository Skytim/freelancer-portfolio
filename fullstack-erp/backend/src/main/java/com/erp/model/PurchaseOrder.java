package com.erp.model;
import jakarta.persistence.*; import lombok.*; import java.math.BigDecimal; import java.time.LocalDateTime;
@Entity @Table(name="purchase_orders") @Data @NoArgsConstructor @AllArgsConstructor @Builder
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
}
