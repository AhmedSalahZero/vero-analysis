drop trigger if exists trg_after_insert_reverse ;
drop trigger if exists trg_after_update_reverse ;
drop trigger if exists trg_after_delete_reverse ;

DELIMITER $$

-- بعد الإضافة
CREATE TRIGGER trg_after_insert_reverse
AFTER INSERT ON reverse_factoring_breakdowns
FOR EACH ROW
BEGIN
    INSERT INTO revenue_contracts (reverse_breakdown_id, study_id, company_id, category_id, monthly_loan_amounts)
    VALUES (NEW.id, NEW.study_id, NEW.company_id, NEW.category, NEW.monthly_loan_amounts);
END$$

-- بعد التعديل
CREATE TRIGGER trg_after_update_reverse
AFTER UPDATE ON reverse_factoring_breakdowns
FOR EACH ROW
BEGIN
    UPDATE revenue_contracts
    SET study_id = NEW.study_id,
        company_id = NEW.company_id,
        category_id = NEW.category,
        monthly_loan_amounts = NEW.monthly_loan_amounts
    WHERE reverse_breakdown_id = NEW.id;
END$$

-- بعد الحذف (اختياري لأن الـ ON DELETE CASCADE بيكفي)
CREATE TRIGGER trg_after_delete_reverse
AFTER DELETE ON reverse_factoring_breakdowns
FOR EACH ROW
BEGIN
    DELETE FROM revenue_contracts WHERE reverse_breakdown_id = OLD.id;
END$$

DELIMITER ;
