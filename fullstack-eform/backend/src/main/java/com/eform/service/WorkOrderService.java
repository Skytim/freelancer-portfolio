package com.eform.service;

import com.eform.dto.WorkOrderRequest;
import com.eform.model.WorkOrder;
import com.eform.model.WorkOrder.Status;
import com.eform.repository.*;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;

@Service
@RequiredArgsConstructor
public class WorkOrderService {

    private final WorkOrderRepository woRepo;
    private final EquipmentRepository equipRepo;
    private final FormTemplateRepository tmplRepo;
    private final UserRepository userRepo;

    public WorkOrder create(WorkOrderRequest req, String username) {
        var equip = equipRepo.findByCode(req.getEquipmentCode())
                .orElseThrow(() -> new RuntimeException("設備不存在: " + req.getEquipmentCode()));
        var tmpl = tmplRepo.findByTemplateKey(req.getTemplateKey())
                .orElseThrow(() -> new RuntimeException("表單模板不存在: " + req.getTemplateKey()));
        var user = userRepo.findByUsername(username)
                .orElseThrow(() -> new RuntimeException("使用者不存在"));

        String orderNo = "WO-" + LocalDateTime.now().format(DateTimeFormatter.ofPattern("yyyyMMdd-HHmmss"));
        var wo = WorkOrder.builder()
                .orderNo(orderNo)
                .equipment(equip)
                .template(tmpl)
                .inspector(user)
                .formData(req.getFormData())
                .notes(req.getNotes())
                .photoUrls(req.getPhotoUrls())
                .status(Status.SUBMITTED)
                .build();
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
