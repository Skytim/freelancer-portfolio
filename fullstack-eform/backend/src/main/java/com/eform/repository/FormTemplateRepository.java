package com.eform.repository;

import com.eform.model.FormTemplate;
import org.springframework.data.jpa.repository.JpaRepository;
import java.util.Optional;

public interface FormTemplateRepository extends JpaRepository<FormTemplate, Long> {
    Optional<FormTemplate> findByTemplateKey(String templateKey);
}
