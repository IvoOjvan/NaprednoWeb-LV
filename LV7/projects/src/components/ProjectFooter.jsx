import { Alert, Button } from "react-bootstrap";

export default function ProjectFooter({ onStartDelete }) {
  return (
    <Alert key="danger" variant="danger">
      Are you sure you want to delete this project?
      <Button variant="danger" className="ms-4" onClick={onStartDelete}>
        Delete
      </Button>
    </Alert>
  );
}
