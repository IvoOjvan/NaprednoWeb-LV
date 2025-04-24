import express from "express";
import cors from "cors";
import { router as project } from "./routes/project.js";

const PORT = process.env.PORT || 5050;
const app = express();

app.use(cors());
app.use(express.json());
app.use("/projects", project);

app.listen(PORT, () => {
  console.log(`Server listening on port ${PORT}`);
});
