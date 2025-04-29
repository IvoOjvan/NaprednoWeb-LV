/*import { useEffect, useRef } from "react";
import { createPortal } from "react-dom";

export default function Modal({ children, onClose }) {
  const dialog = useRef();

  useEffect(() => {
    const modal = dialog.current;

    if (modal) {
      requestAnimationFrame(() => {
        if (!modal.open) {
          modal.showModal();
        }
      });
    }

    return () => {
      if (modal?.open) modal.close();
    };
  }, []);

  return createPortal(
    <dialog className="modal" ref={dialog} onClose={onClose}>
      {children}
    </dialog>,
    document.getElementById("modal")
  );
}
*/
import { Modal, Button } from "react-bootstrap";
export default function ModalConfirmation({
  onClose,
  isDeleting,
  isPendingDeletion,
  handleDelete,
}) {
  return (
    <Modal show={isDeleting} onHide={onClose} centered>
      <Modal.Header closeButton>
        <Modal.Title>Are you sure?</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <p>Deleting the project is a permanent action.</p>
      </Modal.Body>
      <Modal.Footer>
        {isPendingDeletion ? (
          <p className="mb-0">Deleting project...</p>
        ) : (
          <>
            <Button variant="secondary" onClick={onClose}>
              Cancel
            </Button>
            <Button variant="danger" onClick={handleDelete}>
              Delete
            </Button>
          </>
        )}
      </Modal.Footer>
    </Modal>
  );
}
