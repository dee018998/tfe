import {
    ClassicEditor,
    Alignment,
    Autoformat,
    AutoImage,
    Autosave,
    BlockQuote,
    Bold,
    Bookmark,
    CloudServices,
    Code,
    CodeBlock,
    Essentials,
    FindAndReplace,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    FullPage,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HorizontalLine,
    HtmlEmbed,
    ImageBlock,
    ImageCaption,
    ImageInline,
    ImageInsert,
    ImageInsertViaUrl,
    ImageResize,
    ImageStyle,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    Indent,
    IndentBlock,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    MediaEmbed,
    Paragraph,
    PasteFromOffice,
    RemoveFormat,
    ShowBlocks,
    SimpleUploadAdapter,
    SourceEditing,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    Strikethrough,
    Style,
    Subscript,
    Superscript,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextTransformation,
    TodoList,
    Underline
} from './ckeditor/ckeditor5.js';

/**
 * Create a free account with a trial: https://portal.ckeditor.com/checkout?plan=free
 */
const LICENSE_KEY = 'GPL'; // or <YOUR_LICENSE_KEY>.

const editorConfig = {
    toolbar: {
        items: [
            'sourceEditing',
            'showBlocks',
            'findAndReplace',
            '|',
            'heading',
            'style',
            '|',
            'fontSize',
            'fontFamily',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'subscript',
            'superscript',
            'code',
            'removeFormat',
            '|',
            'specialCharacters',
            'horizontalLine',
            'link',
            'bookmark',
            'insertImage',
            'mediaEmbed',
            'insertTable',
            'highlight',
            'blockQuote',
            'codeBlock',
            'htmlEmbed',
            '|',
            'alignment',
            '|',
            'bulletedList',
            'numberedList',
            'todoList',
            'outdent',
            'indent'
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        Alignment,
        Autoformat,
        AutoImage,
        Autosave,
        BlockQuote,
        Bold,
        Bookmark,
        CloudServices,
        Code,
        CodeBlock,
        Essentials,
        FindAndReplace,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        FullPage,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        HorizontalLine,
        HtmlEmbed,
        ImageBlock,
        ImageCaption,
        ImageInline,
        ImageInsert,
        ImageInsertViaUrl,
        ImageResize,
        ImageStyle,
        ImageTextAlternative,
        ImageToolbar,
        ImageUpload,
        Indent,
        IndentBlock,
        Italic,
        Link,
        LinkImage,
        List,
        ListProperties,
        MediaEmbed,
        Paragraph,
        PasteFromOffice,
        RemoveFormat,
        ShowBlocks,
        SimpleUploadAdapter,
        SourceEditing,
        SpecialCharacters,
        SpecialCharactersArrows,
        SpecialCharactersCurrency,
        SpecialCharactersEssentials,
        SpecialCharactersLatin,
        SpecialCharactersMathematical,
        SpecialCharactersText,
        Strikethrough,
        Style,
        Subscript,
        Superscript,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextTransformation,
        TodoList,
        Underline
    ],
    fontFamily: {
        supportAllValues: true
    },
    fontSize: {
        options: [10, 12, 14, 'default', 18, 20, 22],
        supportAllValues: true
    },
    heading: {
        options: [
            {
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
        ]
    },
    htmlSupport: {
        allow: [
            {
                name: /^.*$/,
                styles: true,
                attributes: true,
                classes: true
            }
        ]
    },
    image: {
        toolbar: [
            'toggleImageCaption',
            'imageTextAlternative',
            '|',
            'imageStyle:inline',
            'imageStyle:wrapText',
            'imageStyle:breakText',
            '|',
            'resizeImage'
        ]
    },

    initialData:
        '            <div class="mt-3 text-md-center text-lg-start">\n' +
        '                <h3>\n' +
        '                    This is the first Subtitle,this subtitle should be quite long, either a question or a full sentence.&nbsp;\n' +
        '                </h3>\n' +
        '                <div class="row">\n' +
        '                    <div class="col-sm-12 col-md-6 text-start"><p>\n' +
        '                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut bibendum ipsum. Nunc\n' +
        '                            sodales\n' +
        '                            nibh non semper gravida. Donec ut dui sed mauris semper iaculis sit amet eu metus. Integer\n' +
        '                            commodo purus id diam semper faucibus. Cras gravida justo et purus tempor, eu eleifend neque\n' +
        '                            vestibulum. In aliquam pellentesque lectus sed pharetra. Duis dapibus, justo eget posuere\n' +
        '                            blandit, quam justo feugiat tellus, et lobortis velit massa at lorem. Praesent eget finibus\n' +
        '                            odio. Proin cursus eget libero ut mattis. Curabitur egestas euismod vehicula. Proin nulla\n' +
        '                            ante,\n' +
        '                            venenatis ut eros non, laoreet aliquet magna. Sed dictum nec quam non feugiat. Donec\n' +
        '                            accumsan,\n' +
        '                            justo ut luctus sagittis, libero nibh vulputate orci, quis mattis sapien odio et velit. In\n' +
        '                            auctor, erat nec tincidunt semper, neque neque iaculis nibh, nec tincidunt nisi tellus at\n' +
        '                            quam.\n' +
        '                            Proin et erat sit amet mi fermentum sollicitudin et vel sem.\n' +
        '\n' +
        '                        </p>\n' +
        '                    </div>\n' +
        '                    <div class="col-sm-12 col-md-6 text-start"><p>\n' +
        '                            Donec sodales nisl vulputate, auctor enim non, dignissim quam. Suspendisse a elit sit amet\n' +
        '                            urna\n' +
        '                            vulputate vehicula id vel purus. Phasellus augue turpis, viverra ultrices pretium in,\n' +
        '                            gravida id\n' +
        '                            ligula. Quisque molestie, lorem eget sodales mattis, nisl tortor tempus justo, nec dictum\n' +
        '                            orci\n' +
        '                            felis non neque. Aliquam fermentum nisl ac lacinia pellentesque. Donec eu eros nisl. Etiam\n' +
        '                            tincidunt mattis iaculis. Sed ut posuere odio. Suspendisse nec mi quis ligula vestibulum\n' +
        '                            congue.\n' +
        '                            Vivamus scelerisque neque vel erat laoreet, sit amet iaculis elit sollicitudin. Phasellus\n' +
        '                            nibh\n' +
        '                            turpis, semper eget vulputate id, vestibulum in odio. Vivamus malesuada maximus ante id\n' +
        '                            laoreet.\n' +
        '                            Etiam malesuada accumsan odio, ut congue nisi blandit in.\n' +
        '\n' +
        '                        </p>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div>\n' +
        '                <h3>\n' +
        '                    Second subtitle.\n' +
        '                </h3>\n' +
        '                <ul>\n' +
        '                    <li>\n' +
        '                        <strong>Integrate into your app</strong>: time to bring the editing into your application. Take\n' +
        '                        the\n' +
        '                        code you created and add to your application.\n' +
        '                    </li>\n' +
        '                    <li>\n' +
        '                        <strong>Explore features:</strong> Experiment with different plugins and toolbar options to\n' +
        '                        discover\n' +
        '                        what works best for your needs.\n' +
        '                    </li>\n' +
        '                    <li>\n' +
        '                        <strong>Customize your editor:</strong> Tailor the editor\'s configuration to match your\n' +
        '                        application\'s style and requirements. Or even write your plugin!\n' +
        '                    </li>\n' +
        '                </ul>\n' +
        '                <h4>\n' +
        '                    Second Subtitle.\n' +
        '                </h4>\n' +
        '                <p>\n' +
        '                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eros ipsum, viverra nec magna a,\n' +
        '                    mollis consectetur sem. Ut at odio vestibulum, porta mauris ac, varius neque. Pellentesque habitant\n' +
        '                    morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed feugiat, ipsum tempor\n' +
        '                    laoreet lacinia, dui neque pulvinar diam, in laoreet nulla massa eu metus. Sed ut nibh sagittis,\n' +
        '                    tincidunt dolor vel, blandit tellus. In rhoncus erat sed purus iaculis lacinia. Aenean arcu odio,\n' +
        '                    faucibus vel aliquet quis, commodo vel arcu. Quisque pharetra mauris non finibus maximus. Mauris\n' +
        '                    egestas felis sed tempus molestie. Integer interdum dapibus libero et rhoncus. Duis nec scelerisque\n' +
        '                    ex. Nulla lacus lectus, lobortis in augue quis, faucibus blandit dolor. Suspendisse fringilla enim\n' +
        '                    sed nisi porttitor gravida. Nunc at efficitur urna, nec condimentum quam. Vestibulum nec lorem\n' +
        '                    tortor. Pellentesque cursus odio at imperdiet rhoncus.\n' +
        '\n' +
        '                    Vivamus eu auctor ante. Aliquam ut fermentum velit. Nam vel turpis urna. Pellentesque habitant morbi\n' +
        '                    tristique senectus et netus et malesuada fames ac turpis egestas. Sed imperdiet commodo mollis.\n' +
        '                    Aliquam sit amet magna at tortor aliquam iaculis. Phasellus a purus et diam vulputate scelerisque\n' +
        '                    quis vel arcu. Praesent mollis sit amet lorem fermentum tristique. Vestibulum sit amet augue eu\n' +
        '                    lacus condimentum laoreet. Maecenas quis pharetra mauris. Sed augue magna, sollicitudin non libero\n' +
        '                    eu, mollis laoreet eros. Nullam condimentum urna sit amet metus efficitur dictum. Mauris dignissim\n' +
        '                    elementum nisi quis dapibus. Vestibulum tincidunt leo vel bibendum maximus. Nullam justo nisi,\n' +
        '                    vehicula sed urna ac, imperdiet lobortis libero.\n' +
        '\n' +
        '                    Donec sed varius dolor. Aliquam lobortis erat est. Praesent vel auctor massa, sed dapibus sem.\n' +
        '                    Integer placerat felis nec suscipit pharetra. Vivamus imperdiet pellentesque lorem in rhoncus.\n' +
        '                    Praesent nec hendrerit justo, ut hendrerit ex. Vivamus pretium efficitur lorem sit amet imperdiet.\n' +
        '                    Mauris ac ex eu massa tristique suscipit eget viverra mi. In orci erat, ornare id ex ac, feugiat\n' +
        '                    pellentesque sapien. Quisque vel faucibus dolor. Quisque malesuada felis a tortor blandit suscipit.\n' +
        '                    Sed et mattis leo. Integer sit amet leo rutrum, porttitor est a, luctus orci.\n' +
        '\n' +
        '                    Cras porta cursus neque vitae maximus. Sed ligula ipsum, varius at ipsum at, fringilla molestie\n' +
        '                    augue. Etiam tortor arcu, egestas eget commodo ut, congue eget dui. Morbi in mollis orci. Sed\n' +
        '                    hendrerit vulputate quam, quis blandit dolor pellentesque vel. Nullam nec tristique dui. Mauris\n' +
        '                    dapibus fermentum sem, nec consequat urna egestas et. Vestibulum tincidunt nibh leo, in eleifend sem\n' +
        '                    elementum vitae. Duis malesuada ligula ut neque accumsan varius. Aenean lobortis.\n' +
        '                </p>\n' +
        '            </div>\n' +
        '            <div>\n' +
        '                <h3>\n' +
        '                    Need help?\n' +
        '                </h3>\n' +
        '                <p>\n' +
        '                    See this text, but the editor is not starting up? Check the browser\'s console for clues and\n' +
        '                    guidance. It\n' +
        '                    may be related to an incorrect license key if you use premium features or another feature-related\n' +
        '                    requirement. If you cannot make it work, file a GitHub issue, and we will help as soon as possible!\n' +
        '                </p>\n' +
        '            </div>\n' +
        '            <div class="">\n' +
        '                <h3>\n' +
        '                    Helpful resources\n' +
        '                </h3>\n' +
        '                <ul class="d-flex justify-content-start">\n' +
        '                    <li class="btn btn-sm">\n' +
        '                        <a target="_blank" class="" rel="noopener noreferrer"\n' +
        '                           href="#">Trial sign up</a>,\n' +
        '                    </li>\n' +
        '                    <li class="btn btn-sm">\n' +
        '                        <a target="_blank" rel="noopener noreferrer"\n' +
        '                           href="#">Documentation</a>,\n' +
        '                    </li>\n' +
        '                    <li class="btn btn-sm">\n' +
        '                        <a target="_blank" rel="noopener noreferrer"\n' +
        '                           href="#">GitHub</a>\n' +
        '                    </li>\n' +
        '                    <li class="btn btn-sm">\n' +
        '                        <a target="_blank" rel="noopener noreferrer" href="#">CKEditor Homepage</a>,\n' +
        '                    </li>\n' +
        '                    <li class="btn btn-sm">\n' +
        '                        <a target="_blank" rel="noopener noreferrer" href="#">CKEditor\n' +
        '                            5 Demos</a>,\n' +
        '                    </li>\n' +
        '                </ul>\n' +
        '            </div>',

    licenseKey: LICENSE_KEY,
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    placeholder: 'Type or paste your content here!',
    style: {
        definitions: [
            {
                name: 'Article category',
                element: 'h3',
                classes: ['category']
            },
            {
                name: 'Title',
                element: 'h2',
                classes: ['document-title']
            },
            {
                name: 'Subtitle',
                element: 'h3',
                classes: ['document-subtitle']
            },
            {
                name: 'Info box',
                element: 'p',
                classes: ['info-box']
            },
            {
                name: 'Side quote',
                element: 'blockquote',
                classes: ['side-quote']
            },
            {
                name: 'Marker',
                element: 'span',
                classes: ['marker']
            },
            {
                name: 'Spoiler',
                element: 'span',
                classes: ['spoiler']
            },
            {
                name: 'Code (dark)',
                element: 'pre',
                classes: ['fancy-code', 'fancy-code-dark']
            },
            {
                name: 'Code (bright)',
                element: 'pre',
                classes: ['fancy-code', 'fancy-code-bright']
            }
        ]
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
    }
};
const editorField = document.querySelector('.my_editor')
ClassicEditor.create(editorField, editorConfig)
    .then(newEditor => {
        newEditor.model.document.on("change", function () {
            const editorData = newEditor.getData();
            editorField.value = editorData
        })

    })
    .catch(err =>{
        console.error(err.stack)
    } );


