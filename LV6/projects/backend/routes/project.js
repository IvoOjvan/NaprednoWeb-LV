import express from "express";
import db from "../db/connection.js";
import { ObjectId } from "mongodb";

export const router = express.Router();

router.get("/", async (req, res) => {
  let collection = await db.collection("projects");
  let results = await collection.find({}).toArray();

  if (results) {
    res.send(results).status(200);
  } else {
    res.send("No projects found.").status(404);
  }
});

router.post("/", async (req, res) => {
  try {
    let collection = await db.collection("projects");
    const newProject = req.body;

    if (newProject) {
      const result = await collection.insertOne(newProject);
      if (result?.acknowledged) {
        res.status(200).json({ message: "Project created successfuly." });
      } else {
        res.status(500).json({ message: "Failed to create project." });
      }
    }
  } catch (error) {
    res.status(400).json({ message: "Failed to save project." });
  }
});

router.get("/:id", async (req, res) => {
  let collection = await db.collection("projects");
  const id = req?.params?.id;
  const query = { _id: new ObjectId(id) };
  let project = await collection.findOne(query);

  if (project) {
    res.status(200).send(project);
  } else {
    res.status(404).json({ message: "No project found with ID: " + id });
  }
});

router.delete("/:id", async (req, res) => {
  let collection = await db.collection("projects");
  const id = req?.params?.id;
  const query = { _id: new ObjectId(id) };
  let result = await collection.deleteOne(query);

  if (result && result.deletedCount) {
    res.status(200).json({ message: "Project deleted." });
  } else {
    res.status(404).json({ message: "There is no such project." });
  }
});

router.patch("/:id", async (req, res) => {
  const id = req?.params?.id;
  const updates = req.body;

  let collection = await db.collection("projects");
  let result = await collection.updateOne(
    { _id: new ObjectId(id) },
    { $set: updates }
  );

  if (result.matchedCount === 0) {
    res.status(404).json({ error: "No matching project found." });
  } else if (result.modifiedCount === 0) {
    res.status(200).json("No changes made. Project is up to date.");
  } else {
    res.status(200).json("Project updated.");
  }
});
