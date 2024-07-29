package com.example.demo.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.example.demo.entity.Music;
import com.example.demo.repository.MusicCrudRepository;

@Service
public class MusicServiceImpl implements MusicService {

	@Autowired
	MusicCrudRepository repository;
	
	@Override
	public Iterable<Music> findAll() {
		return repository.findAll();
	}

	@Override
	public void insertMusic(Music music) {
		repository.save(music);
	}

	@Override
    public Music findById(Integer id) {
        return repository.findById(id).orElse(null);
    }
	
	@Override
    public void deleteMusicById(Integer id) {
        repository.deleteById(id);
    }
}