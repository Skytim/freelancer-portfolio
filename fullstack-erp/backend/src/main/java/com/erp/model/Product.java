package com.erp.model;
import jakarta.persistence.*; import lombok.*; import java.math.BigDecimal;
@Entity @Table(name="products") @Data @NoArgsConstructor @AllArgsConstructor @Builder
public class Product {
    @Id @GeneratedValue(strategy=GenerationType.IDENTITY) private Long id;
    @Column(unique=true,nullable=false) private String sku;
    @Column(nullable=false) private String name;
    private String category; private String unit;
    private BigDecimal costPrice; private BigDecimal sellPrice;
    private Integer stockQty; private Integer safetyStock;
    private String branch; // 台北/台中/高雄
}
