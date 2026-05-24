package com.eform.model;

import jakarta.persistence.*;
@Entity
@Table(name = "form_templates")
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

    public FormTemplate() {}
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }
    public String getTemplateKey() { return templateKey; }
    public void setTemplateKey(String templateKey) { this.templateKey = templateKey; }
    public String getName() { return name; }
    public void setName(String name) { this.name = name; }
    public String getEquipmentType() { return equipmentType; }
    public void setEquipmentType(String equipmentType) { this.equipmentType = equipmentType; }
    public String getFieldsJson() { return fieldsJson; }
    public void setFieldsJson(String fieldsJson) { this.fieldsJson = fieldsJson; }
}
