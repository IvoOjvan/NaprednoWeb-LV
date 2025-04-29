import express from "express";
import db from "../db/connection.js";
import { ObjectId } from "mongodb";

export const router = express.Router();

router.post("/login", async (req, res) => {
  try {
    const { email, password } = req.body;
    if (!email || !password) {
      return res.status(400).json({ message: "Missing email or password." });
    }

    const collection = await db.collection("users");
    const query = { email: email, password: password };
    const user = await collection.findOne(query);

    if (!user) {
      return res
        .status(404)
        .json({ message: "Failed to failed user with these credentials." });
    } else {
      res.status(200).send(user);
    }
  } catch (error) {
    res.status(500).json({ message: "Server error." });
  }
});

router.post("/register", async (req, res) => {
  try {
    const { email, password, firstname, lastname } = req.body;

    if (!email || !password || !firstname || !lastname) {
      return res.status(400).json({ message: "Missing fields." });
    }

    const collection = await db.collection("users");

    const existingUser = await collection.findOne({ email });
    if (existingUser) {
      return res
        .status(400)
        .json({ message: "This e-mail address is already in use." });
    }

    const newUser = {
      email,
      password,
      firstname,
      lastname,
    };

    await collection.insertOne(newUser);
    res.status(200).json({ message: "Registration successfull" });
  } catch (error) {
    res.status(500).json({ message: "Server error." });
  }
});

router.get("/users", async (req, res) => {
  try {
    const collection = await db.collection("users");
    const users = await collection.find({}).toArray();

    if (users) {
      res.status(200).send(users);
    } else {
      res.status(404).json({ message: "No users found." });
    }
  } catch (error) {
    res.status(500).json({ message: "Server error." });
  }
});
