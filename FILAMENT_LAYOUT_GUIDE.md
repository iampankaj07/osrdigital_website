# Laravel Filament Layout Guide for Edit/Add Forms

## Best Practices for Content Management Layouts

### 1. **Grid Structure**
```php
// Main 12-column grid
Grid::make(12)
    ->schema([
        // Main content area (8 columns)
        Grid::make(1)->columnSpan(8)->schema([...]),
        // Sidebar (4 columns)
        Grid::make(1)->columnSpan(4)->schema([...]),
    ])
```

### 2. **Section Organization**
```php
Section::make('Content')
    ->schema([...])  // Main content fields

Section::make('SEO & Meta Information')
    ->schema([...])  // SEO fields
    ->collapsible()
    ->collapsed()

Section::make('Publish')
    ->schema([...])  // Status, dates, visibility

Section::make('Featured Image')
    ->schema([...])  // Image upload

Section::make('Categories')
    ->schema([...])  // Category selection

Section::make('Author Information')
    ->schema([...])  // Author details
    ->collapsible()
    ->collapsed()

Section::make('Discussion')
    ->schema([...])  // Comments, trackbacks
    ->collapsible()
    ->collapsed()
```

### 3. **Field Configuration**
```php
TextInput::make('title')
    ->required()
    ->live(onBlur: true)
    ->afterStateUpdated(fn ($context, $state, $set) =>
        $context === 'create' ? $set('slug', Str::slug($state)) : null
    )
    ->extraAttributes(['class' => 'text-lg font-semibold'])

TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->prefix(url('/') . '/content/')

RichEditor::make('content')
    ->required()
    ->toolbarButtons([...])

FileUpload::make('featured_image')
    ->image()
    ->imageEditor()
    ->imageResizeMode('cover')
    ->maxSize(2048)
```

### 4. **Responsive Design**
- Use `columnSpanFull()` for full-width fields
- Use `Grid::make(2)` for 2-column layouts in sections
- Ensure sidebar elements stack properly on mobile

### 5. **User Experience**
- Use collapsible sections for optional/advanced fields
- Provide helpful hints and placeholders
- Use consistent labeling and field ordering
- Group related fields together

## Layout Components Hierarchy

```
Schema (12 columns)
├── Grid (12 columns)
│   ├── Grid (8 columns) - Main Content
│   │   ├── Section - Content
│   │   ├── Section - SEO (collapsible)
│   │   └── Section - Additional Details (collapsible)
│   └── Grid (4 columns) - Sidebar
│       ├── Section - Publish
│       ├── Section - Featured Image
│       ├── Section - Categories
│       ├── Section - Author (collapsible)
│       └── Section - Discussion (collapsible)
```

## Common Issues & Solutions

### Issue: Fields stacking vertically instead of side-by-side
**Solution**: Ensure proper `columnSpan()` values and Grid structure

### Issue: Sections not collapsing properly
**Solution**: Use `->collapsible()->collapsed()` on Section components

### Issue: RichEditor toolbar buttons not working
**Solution**: Verify button names match Filament v4 documentation

### Issue: Image upload not working
**Solution**: Use `->image()->imageEditor()` with proper resize settings

## Performance Tips

1. Use `->live(onBlur: true)` sparingly
2. Implement proper validation rules
3. Use `->hint()` for user guidance
4. Group database queries efficiently
5. Consider using `->dehydrateStateUsing()` for complex transformations</content>
<parameter name="filePath">/Users/shusridad/Sites/osrdigital/FILAMENT_LAYOUT_GUIDE.md
