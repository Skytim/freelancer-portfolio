package com.eform.model;

import jakarta.persistence.*;
import lombok.*;

@Entity
@Table(name = "equipment")
@Data @NoArgsConstructor @AllArgsConstructor @Builder
public class Equipment {
    @Id @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(unique = true, nullable = false)
    private String code;

    @Column(nullable = false)
    private String name;

    private String location;
    private String type; // UPS, INROW_AC, FIRE, ENV, CABINET
    private String qrCode;
}
