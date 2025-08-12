drop trigger if exists trg_after_insert_ljsb ;
drop trigger if exists trg_after_update_ljsb ;
drop trigger if exists trg_after_delete_ljsb ;

DELIMITER $$

-- بعد الإضافة
CREATE TRIGGER trg_after_insert_ljsb
AFTER INSERT ON ijara_mortgage_breakdowns
FOR EACH ROW
BEGIN
    INSERT INTO revenue_contracts (ijara_breakdown_id, study_id, company_id, monthly_loan_amounts)
    VALUES (NEW.id, NEW.study_id, NEW.company_id, NEW.monthly_loan_amounts);
END$$

-- بعد التعديل
CREATE TRIGGER trg_after_update_ljsb
AFTER UPDATE ON ijara_mortgage_breakdowns
FOR EACH ROW
BEGIN
    UPDATE revenue_contracts
    SET study_id = NEW.study_id,
        company_id = NEW.company_id,
        -- category_id = NEW.category_id,
        monthly_loan_amounts = NEW.monthly_loan_amounts
    WHERE ijara_breakdown_id = NEW.id;
END$$

-- بعد الحذف (اختياري لأن الـ ON DELETE CASCADE بيكفي)
CREATE TRIGGER trg_after_delete_ljsb
AFTER DELETE ON ijara_mortgage_breakdowns
FOR EACH ROW
BEGIN
    DELETE FROM revenue_contracts WHERE ijara_breakdown_id = OLD.id;
END$$

DELIMITER ;
