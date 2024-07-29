package com.example.demo.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.example.demo.entity.Music;
import com.example.demo.form.MusicForm;
import com.example.demo.service.MusicService;

@Controller
public class MusicController {
	@Autowired
	MusicService service;
	
	@GetMapping("index")
	public String indexView() {
		return "index";
	}

	/*
	 * @PostMapping("dbselect") public String listView(Model model) {
	 * Iterable<Member> list = service.findAll(); model.addAttribute("list",list);
	 * return "list"; }
	 */
	
	@PostMapping(value="menu" ,params="select")
	public String listView(Model model) {
		Iterable<Music> list = service.findAll();
		model.addAttribute("model_list",list);
		return "list";
	}
	@PostMapping(value="menu" ,params="insert")
	public String musicInsertView(){
		return "music-insert";
	}
	@PostMapping(value="menu" ,params="edit")
	public String musicEditView(Model model){
		Iterable<Music> list = service.findAll();
		model.addAttribute("model_list",list);
		return "music-edit";
	}
	
	@PostMapping("music-updating")
    public String musicUpdatingView(@RequestParam("song_id") Integer songId, Model model) {
		Music list = service.findById(songId);
		model.addAttribute("model_list",list);
        return "music-updating";
    }
	
	@PostMapping("music-delete")
    public String musicDeleteView(@RequestParam("song_id") Integer song_id) {
        service.deleteMusicById(song_id);
        return "music-complete"; // 削除後にリダイレクト
    }
	
	@PostMapping("insert")
	public String musicInsertView(MusicForm m) {
		Music music = new Music(
				m.getSong_id(),
				m.getInput_song_name(),
				m.getInput_singer()
				);
		service.insertMusic(music);
		return "music-complete";
	}
}
