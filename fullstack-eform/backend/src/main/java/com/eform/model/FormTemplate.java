package com.eform.model;

import jakarta.persistence.*;
import lombok.*;

@Entity
@Table(name = "form_templates")
@Data @NoArgsConstructor @AllArgsConstructor @Builder
public class FormTemplate {
    @Id @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(unique = true, nullable = false)
    private String templateKey; // ups_inspection, inrow_inspection, etc.

    @Column(nullable = false)
    private String name; // UPS 巡檢表

    private String equipmentType; // UPS, INROW_AC, FIRE, ENV, CABINET

    @Column(columnDefinition = "TEXT")
    private String fieldsJson; // JSON Schema for form fields
}
