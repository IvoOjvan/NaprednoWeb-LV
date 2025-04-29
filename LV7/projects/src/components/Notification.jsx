import { ToastContainer, Toast } from "react-bootstrap";

export default function ToastNotification({ actionInfo, show, setShow }) {
  if (!actionInfo) return;
  return (
    <ToastContainer className="p-3" position="top-end" style={{ zIndex: 100 }}>
      <Toast
        bg={actionInfo.type.toLowerCase() || "primary"}
        onClose={() => setShow(false)}
        show={show}
        delay={1500}
        autohide
      >
        <Toast.Header closeButton={false}>
          <img src="holder.js/20x20?text=%20" className="rounded me-2" alt="" />
          <strong className="me-auto">{actionInfo.message}</strong>
        </Toast.Header>
      </Toast>
    </ToastContainer>
  );
}
