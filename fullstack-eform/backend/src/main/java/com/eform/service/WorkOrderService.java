package com.eform.service;

import com.eform.dto.WorkOrderRequest;
import com.eform.model.WorkOrder;
import com.eform.model.WorkOrder.Status;
import com.eform.repository.*;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;

@Service

public class WorkOrderService {

    private final WorkOrderRepository woRepo;
    private final EquipmentRepository equipRepo;
    private final FormTemplateRepository tmplRepo;
    private final UserRepository userRepo;


    public WorkOrderService(WorkOrderRepository woRepo, EquipmentRepository equipRepo, FormTemplateRepository tmplRepo, UserRepository userRepo) {
        this.woRepo = woRepo;
        this.equipRepo = equipRepo;
        this.tmplRepo = tmplRepo;
        this.userRepo = userRepo;
    }

    public WorkOrder create(WorkOrderRequest req, String username) {
        var equip = equipRepo.findByCode(req.getEquipmentCode())
                .orElseThrow(() -> new RuntimeException("設備不存在: " + req.getEquipmentCode()));
        var tmpl = tmplRepo.findByTemplateKey(req.getTemplateKey())
                .orElseThrow(() -> new RuntimeException("表單模板不存在: " + req.getTemplateKey()));
        var user = userRepo.findByUsername(username)
                .orElseThrow(() -> new RuntimeException("使用者不存在"));

        String orderNo = "WO-" + LocalDateTime.now().format(DateTimeFormatter.ofPattern("yyyyMMdd-HHmmss"));
        WorkOrder wo = new WorkOrder();
        wo.setOrderNo(orderNo);
        wo.setEquipment(equip);
        wo.setTemplate(tmpl);
        wo.setInspector(user);
        wo.setFormData(req.getFormData());
        wo.setNotes(req.getNotes());
        wo.setPhotoUrls(req.getPhotoUrls());
        wo.setStatus(Status.SUBMITTED);
        return woRepo.save(wo);
    }

    public List<WorkOrder> listByEquipment(Long equipId) {
        return woRepo.findByEquipmentIdOrderByCreatedAtDesc(equipId);
    }

    public List<WorkOrder> listByInspector(String username) {
        var user = userRepo.findByUsername(username).orElseThrow();
        return woRepo.findByInspectorIdOrderByCreatedAtDesc(user.getId());
    }
}
